<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;

class TestClearCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:clear-cart {--guest-token=} {--payment-id=} {--add-test-data} {--simulate-payment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test clearing cart functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing cart clearing functionality...');
        
        if ($this->option('add-test-data')) {
            $this->info('Adding test cart data...');
            Cart::create([
                'guest_token' => 'test-token-123',
                'course_id' => 4
            ]);
            $this->info('Test cart data added!');
        }

        if ($this->option('simulate-payment')) {
            $this->info('Simulating payment process...');
            
            // Create test payment
            $payment = Payment::create([
                'user_id' => 1, // Assuming user ID 1 exists
                'payment_type' => 'xendit',
                'payment_id' => 'test-payment-' . time(),
                'external_id' => 'test-external-' . time(),
                'amount' => 100000,
                'status' => 'paid',
                'payment_url' => 'https://test.com',
                'guest_token' => 'test-token-123'
            ]);
            
            $this->info("Payment created with ID: {$payment->id}");
            
            // Create test order
            $order = Order::create([
                'user_id' => 1,
                'course_id' => 4,
                'payment_id' => $payment->id,
                'amount' => 100000,
                'status' => 'completed'
            ]);
            
            $this->info("Order created with ID: {$order->id}");
            
            // Now test clear cart
            $this->info("Testing clear cart with payment ID: {$payment->id}");
            
            // Simulate the clear cart method
            $deletedByToken = Cart::where('guest_token', $payment->guest_token)->delete();
            $this->info("Deleted by guest token: {$deletedByToken} items");
            
            $courseIds = Order::where('payment_id', $payment->id)
                             ->where('status', 'completed')
                             ->pluck('course_id')
                             ->toArray();
            
            $deletedByCourse = Cart::whereIn('course_id', $courseIds)->delete();
            $this->info("Deleted by course IDs: {$deletedByCourse} items");
        }
        
        // Show current cart items
        $cartCount = Cart::count();
        $this->info("Current cart items: {$cartCount}");
        
        if ($cartCount > 0) {
            $this->table(
                ['ID', 'Guest Token', 'Course ID', 'Created At'], 
                Cart::select('id', 'guest_token', 'course_id', 'created_at')->get()->toArray()
            );
        }
        
        $guestToken = $this->option('guest-token');
        $paymentId = $this->option('payment-id');
        
        if ($guestToken) {
            $this->info("Testing clear by guest token: {$guestToken}");
            $deleted = Cart::where('guest_token', $guestToken)->delete();
            $this->info("Deleted {$deleted} items");
        }
        
        if ($paymentId) {
            $this->info("Testing clear by payment ID: {$paymentId}");
            $payment = Payment::find($paymentId);
            if ($payment) {
                $this->info("Payment found: {$payment->payment_id}, Guest Token: {$payment->guest_token}");
                
                $courseIds = Order::where('payment_id', $paymentId)
                                 ->pluck('course_id')
                                 ->toArray();
                
                $this->info("Course IDs in this payment: " . implode(', ', $courseIds));
                
                if (!empty($courseIds)) {
                    $deleted = Cart::whereIn('course_id', $courseIds)->delete();
                    $this->info("Deleted {$deleted} cart items by course IDs");
                }
            } else {
                $this->error("Payment not found");
            }
        }
        
        $finalCount = Cart::count();
        $this->info("Final cart items: {$finalCount}");
        
        return 0;
    }
}
