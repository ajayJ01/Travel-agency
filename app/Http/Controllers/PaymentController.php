<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function process(Request $request)
    {
        $amount = $request->input('amount');
        $paymentMethod = $request->input('payment_method');

        $success = $this->paymentService->processPayment($amount, $paymentMethod);

        if ($success) {
            return redirect()->route('payment.success');
        } else {
            return redirect()->route('payment.failure');
        }
    }
}