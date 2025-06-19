<?php

namespace App\Repositories;

use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceCallback;
use Exception;
use Illuminate\Support\Facades\Log;

class XenditRepository
{
    protected $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.secret_key'));
        $this->invoiceApi = new InvoiceApi();
    }

    /**
     * Handle payment using Xendit Invoice
     */
    public function handlePayment(array $data)
    {
        try {
            // Calculate total amount
            $totalAmount = 0;
            $items = [];
            
            foreach ($data['course_id'] as $index => $courseId) {
                $coursePrice = (float) $data['course_price'][$index];
                $totalAmount += $coursePrice;
                
                $items[] = [
                    'name' => $data['course_name'][$index],
                    'quantity' => 1,
                    'price' => $coursePrice,
                    'category' => 'Course'
                ];
            }

            // Create invoice request
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => 'invoice_' . time() . '_' . $data['user_id'],
                'description' => 'Pembayaran Kursus - ' . implode(', ', $data['course_name']),
                'amount' => $totalAmount,
                'invoice_duration' => 86400, // 24 hours
                'currency' => 'IDR',
                'reminder_time' => 1,
                'customer' => [
                    'given_names' => $data['user_name'] ?? 'Customer',
                    'email' => $data['email'],
                ],
                'customer_notification_preference' => [
                    'invoice_created' => ['email'],
                    'invoice_reminder' => ['email'],
                    'invoice_paid' => ['email'],
                    'invoice_expired' => ['email'],
                ],
                'success_redirect_url' => route('payment.success'),
                'failure_redirect_url' => route('payment.failed'),
                'items' => $items,
                'fees' => [
                    [
                        'type' => 'ADMIN',
                        'value' => 5000 // Admin fee 5000 IDR
                    ]
                ]
            ]);

            // Create invoice
            $response = $this->invoiceApi->createInvoice($createInvoiceRequest);
            
            Log::info('Xendit Invoice Created', ['response' => $response]);
            
            return [
                'success' => true,
                'invoice_id' => $response['id'],
                'invoice_url' => $response['invoice_url'],
                'external_id' => $response['external_id'],
                'amount' => $response['amount'],
                'status' => $response['status']
            ];

        } catch (Exception $e) {
            Log::error('Xendit Payment Error', ['error' => $e->getMessage()]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get invoice details
     */
    public function getInvoice($invoiceId)
    {
        try {
            $response = $this->invoiceApi->getInvoiceById($invoiceId);
            return $response;
        } catch (Exception $e) {
            Log::error('Get Xendit Invoice Error', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Handle webhook callback
     */
    public function handleWebhook($payload)
    {
        try {
            // Verify webhook token if needed
            $webhookToken = config('xendit.webhook_verification_token');
            
            if ($webhookToken && isset($payload['webhook_token'])) {
                if ($payload['webhook_token'] !== $webhookToken) {
                    Log::warning('Invalid webhook token');
                    return false;
                }
            }

            // Process the webhook based on event type
            $externalId = $payload['external_id'];
            $status = $payload['status'];
            $invoiceId = $payload['id'];

            Log::info('Xendit Webhook Received', [
                'external_id' => $externalId,
                'status' => $status,
                'invoice_id' => $invoiceId
            ]);

            // Update payment status in database
            // This should be implemented based on your payment/order model structure
            
            return [
                'external_id' => $externalId,
                'status' => $status,
                'invoice_id' => $invoiceId,
                'amount' => $payload['amount'] ?? 0
            ];

        } catch (Exception $e) {
            Log::error('Xendit Webhook Error', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Create payment link for multiple payment methods
     */
    public function createPaymentLink(array $data)
    {
        // This can be extended to use Xendit's Payment Request API
        // for more payment method options
        return $this->handlePayment($data);
    }
}
