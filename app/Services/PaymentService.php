<?php

namespace App\Services;

use App\Repositories\XenditRepository;

class PaymentService
{
    protected $xenditRepository;

    public function __construct(XenditRepository $xenditRepository)
    {
        $this->xenditRepository = $xenditRepository;
    }

    public function processPayment(array $data)
    {
        switch ($data['payment_type']) {
            case 'xendit':
                return $this->xenditRepository->handlePayment($data);

            default:
                throw new \Exception('Unsupported payment type: ' . $data['payment_type']);
        }
    }

    public function handleWebhook($paymentType, $payload)
    {
        switch ($paymentType) {
            case 'xendit':
                return $this->xenditRepository->handleWebhook($payload);
                
            default:
                throw new \Exception('Unsupported payment webhook type: ' . $paymentType);
        }
    }
}
