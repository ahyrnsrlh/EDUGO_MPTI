<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class XenditController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }    /**
     * Create Xendit payment
     */
    public function createPayment(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|array',
                'course_name' => 'required|array',
                'course_price' => 'required|array',
                'course_image' => 'required|array',
            ]);

            // Get guest token from cookie
            $guestToken = $request->cookie('guest_token');

            $paymentData = [
                'payment_type' => 'xendit',
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'course_id' => $request->course_id,
                'course_name' => $request->course_name,
                'course_price' => $request->course_price,
                'course_image' => $request->course_image,
                'guest_token' => $guestToken,
            ];

            $result = $this->paymentService->processPayment($paymentData);

            if ($result['success']) {
                // Save payment record
                $payment = Payment::create([
                    'user_id' => Auth::id(),
                    'payment_type' => 'xendit',
                    'payment_id' => $result['invoice_id'],
                    'external_id' => $result['external_id'],
                    'amount' => $result['amount'],
                    'status' => 'pending',
                    'payment_url' => $result['invoice_url'],
                    'guest_token' => $guestToken, // Store guest token
                ]);

                // Create orders for each course
                foreach ($request->course_id as $index => $courseId) {
                    Order::create([
                        'user_id' => Auth::id(),
                        'course_id' => $courseId,
                        'payment_id' => $payment->id,
                        'amount' => $request->course_price[$index],
                        'status' => 'pending',
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'payment_url' => $result['invoice_url'],
                    'message' => 'Pembayaran berhasil dibuat. Silakan lanjutkan pembayaran.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat pembayaran: ' . $result['error']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Xendit Payment Creation Error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat pembayaran.'
            ], 500);
        }
    }

    /**
     * Handle Xendit webhook
     */
    public function webhook(Request $request)
    {
        try {
            $payload = $request->all();
            
            Log::info('Xendit Webhook Received', ['payload' => $payload]);

            $result = $this->paymentService->handleWebhook('xendit', $payload);

            if ($result) {
                // Update payment status
                $payment = Payment::where('payment_id', $result['invoice_id'])
                                 ->orWhere('external_id', $result['external_id'])
                                 ->first();

                if ($payment) {                    DB::transaction(function() use ($payment, $result, $payload) {
                        // Update payment status
                        $payment->update([
                            'status' => strtolower($result['status'])
                        ]);                        // Update related orders
                        if (strtolower($result['status']) === 'paid') {
                            Order::where('payment_id', $payment->id)
                                 ->update(['status' => 'completed']);
                            
                            // Clear cart after successful payment using multiple approaches
                            $this->clearUserCart($payment->user_id, $payment->guest_token);
                            $this->clearCartByCourseIds($payment->id);
                        } elseif (in_array(strtolower($result['status']), ['expired', 'failed'])) {
                            Order::where('payment_id', $payment->id)
                                 ->update(['status' => 'failed']);
                        }
                    });

                    Log::info('Payment status updated successfully', [
                        'payment_id' => $payment->id,
                        'status' => $result['status']
                    ]);
                }

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false], 400);

        } catch (\Exception $e) {
            Log::error('Xendit Webhook Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }    /**
     * Payment success page
     */
    public function success(Request $request)
    {
        $invoiceId = $request->get('invoice_id');
        
        if ($invoiceId) {
            $payment = Payment::where('payment_id', $invoiceId)->first();            if ($payment && $payment->status === 'paid') {
                // Clear cart for completed payment using multiple approaches
                $this->clearUserCart($payment->user_id, $payment->guest_token);
                $this->clearCartByCourseIds($payment->id);
                
                return view('payment.success', compact('payment'));
            }
        }

        return view('payment.success')->with('message', 'Pembayaran berhasil diproses.');
    }

    /**
     * Payment failed page
     */
    public function failed(Request $request)
    {
        return view('payment.failed')->with('message', 'Pembayaran gagal atau dibatalkan.');
    }

    /**
     * Check payment status
     */
    public function checkStatus(Request $request)
    {
        try {
            $paymentId = $request->get('payment_id');
            
            $payment = Payment::where('payment_id', $paymentId)
                             ->orWhere('external_id', $paymentId)
                             ->first();

            if ($payment) {
                return response()->json([
                    'success' => true,
                    'status' => $payment->status,
                    'payment' => $payment
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Check Payment Status Error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengecek status pembayaran'
            ], 500);        }
    }

    /**
     * Redirect to checkout if accessed via GET
     */
    public function redirectToCheckout()
    {
        return redirect()->route('checkout.index')->with('error', 'Silakan lakukan pembayaran melalui halaman checkout.');
    }    /**
     * Clear user cart after successful payment
     */
    private function clearUserCart($userId, $guestToken = null)
    {
        try {
            $deletedCount = 0;
            
            Log::info('Starting clearUserCart', [
                'user_id' => $userId,
                'guest_token' => $guestToken
            ]);
            
            if ($guestToken) {
                // Clear cart using guest token (more accurate)
                $deletedCount = Cart::where('guest_token', $guestToken)->delete();
                
                Log::info('Cart cleared using guest token after successful payment', [
                    'user_id' => $userId,
                    'guest_token' => $guestToken,
                    'deleted_items' => $deletedCount
                ]);
            } else {
                // Fallback: Clear cart items for completed course purchases
                $completedOrders = Order::where('user_id', $userId)
                                       ->where('status', 'completed')
                                       ->pluck('course_id')
                                       ->toArray();

                if (!empty($completedOrders)) {
                    $deletedCount = Cart::whereIn('course_id', $completedOrders)->delete();
                    
                    Log::info('Cart cleared using course IDs after successful payment', [
                        'user_id' => $userId,
                        'course_ids' => $completedOrders,
                        'deleted_items' => $deletedCount
                    ]);
                }
            }
              } catch (\Exception $e) {
            Log::error('Error clearing cart after payment', [
                'user_id' => $userId,
                'guest_token' => $guestToken,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Clear cart by course IDs from completed orders
     */
    private function clearCartByCourseIds($paymentId)
    {
        try {
            // Get course IDs from this payment's orders
            $courseIds = Order::where('payment_id', $paymentId)
                             ->where('status', 'completed')
                             ->pluck('course_id')
                             ->toArray();

            if (!empty($courseIds)) {
                // Delete cart items for these specific courses
                $deletedCount = Cart::whereIn('course_id', $courseIds)->delete();
                
                Log::info('Cart cleared by course IDs after successful payment', [
                    'payment_id' => $paymentId,
                    'course_ids' => $courseIds,
                    'deleted_items' => $deletedCount
                ]);
                
                return $deletedCount;
            }
            
        } catch (\Exception $e) {
            Log::error('Error clearing cart by course IDs', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage()
            ]);
        }
        
        return 0;
    }
}
