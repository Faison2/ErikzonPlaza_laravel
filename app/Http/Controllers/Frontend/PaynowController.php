<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PaynowPayment;
use Illuminate\Http\Request;
use Paynow\Payments\Paynow;

class PaynowController extends Controller
{
    protected Paynow $paynow;

    public function __construct()
    {
        $this->paynow = new Paynow(
            config('services.paynow.integration_id'),
            config('services.paynow.integration_key'),
            url('/payment/update'),
            url('/payment/return')  // Customer will be redirected here after payment
        );
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Create payment
        $reference = 'INV'.time();
        $payment = $this->paynow->createPayment($reference, 'donniecode@gmail.com');
        $payment->add('Eplaza Checkout #'.$request->user_id, $request->amount);

        // Create pending payment record
        PaynowPayment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'reference' => $reference,
            'payment_status' => 'pending',
        ]);

        // Send to Paynow
        $response = $this->paynow->send($payment);

        if ($response->success()) {
            // Save poll url for status checks
            PaynowPayment::where('reference', $reference)
                ->update(['poll_url' => $response->pollUrl()]);

            return redirect($response->redirectUrl());
        }

        return redirect()->back()->with('error', 'Failed to initiate payment');
    }

    public function update(Request $request)
    {
        $payment = PaynowPayment::latest()->first();
        if ($payment && $payment->poll_url) {
            $status = $this->paynow->pollTransaction($payment->poll_url);

            if ($status->paid()) {
                $payment->update([
                    'payment_status' => 'paid',
                    'payment_method' => $status->data()['method'] ?? null,
                    'paynow_response' => $status->data(),
                    'paid_at' => now(),
                ]);

                //               U can insert any other table. this works when payment is successfully.

                return redirect(route('home'))
                    ->with('success', 'Payment was successfully');
            }
        }

        return response()->json(['status' => 'pending']);
    }

    public function return(Request $request)
    {
        return redirect()->route('home');
    }
}
