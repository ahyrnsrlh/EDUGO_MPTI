<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        return view('frontend.pages.cart.index');
    }



    public function fetchCart(Request $request)
    {

        // Handle the AJAX request to get the cart data
        $cart = $this->cartService->viewCart($request);

        $guestToken = $request->cookie('guest_token') ?? Str::uuid();

        $cartItems = Cart::with('course')->where('guest_token', $guestToken)->get();

        // Total Amount (discounted বা selling price) হিসাব করা
        $subTotal = $cartItems->sum(function ($cartItem) {
            $price = $cartItem->course->discount_price ?? $cartItem->course->selling_price;
            return $cartItem->quantity * ($price ?? 0);
        });

        $html = view('frontend.pages.cart.partial.main', compact('cart', 'subTotal'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }



    public function addToCart(Request $request)
    {

        $validated_data = $request->validate([
            'course_id' => 'required|exists:courses,id', // Check if course_id exists in the courses table
            'quantity' => 'nullable|integer|min:1', // Optional quantity
        ]);

        $course_id = $validated_data['course_id'];

        return $this->cartService->createCart($course_id, $request);
    }

    public function cartAll(Request $request)
    {

        $cart =  $this->cartService->viewCart($request);

        // Total Amount (discounted বা selling price) হিসাব করা
        $subTotal = $cart->sum(function ($cartItem) {
            $price = $cartItem->course->discount_price ?? $cartItem->course->selling_price;
            return $cartItem->quantity * ($price ?? 0);
        });

        $html = view('frontend.pages.home.partials.cart', compact('cart', 'subTotal'))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html,
        ]);
    }

    public function removeCart(Request $request)
    {
        $cartItem = Cart::find($request->id); // Change 'Cart' to your model
        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Cart item not found']);
        }

        $cartItem->delete(); // Remove the course from the cart

        return response()->json(['status' => 'success', 'message' => 'Course removed from cart']);
    }

    /**
     * Clear cart after successful payment
     */
    public function clearCartAfterPayment(Request $request)
    {
        try {
            $guestToken = $request->cookie('guest_token');
            
            Log::info('Clear cart after payment called', [
                'guest_token' => $guestToken,
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]);
            
            if ($guestToken) {
                $deletedCount = Cart::where('guest_token', $guestToken)->delete();
                
                Log::info('Cart items deleted', [
                    'guest_token' => $guestToken,
                    'deleted_count' => $deletedCount
                ]);
                
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Cart cleared successfully',
                    'deleted_items' => $deletedCount
                ]);
            }
            
            Log::warning('No guest token found for clearing cart', [
                'cookies' => $request->cookies->all()
            ]);
            
            return response()->json([
                'status' => 'error', 
                'message' => 'No guest token found'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to clear cart after payment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error', 
                'message' => 'Failed to clear cart: ' . $e->getMessage()
            ]);
        }
    }

    
}
