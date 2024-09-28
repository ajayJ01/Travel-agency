<?php

namespace App\Services;

class PaymentService
{
    public function processPayment(float $amount, string $paymentMethod): bool
    {
        // Integrate with payment gateway API
        // Example pseudo-code
        $response = $this->paymentGateway->charge($amount, $paymentMethod);

        return $response->isSuccessful();
    }
}