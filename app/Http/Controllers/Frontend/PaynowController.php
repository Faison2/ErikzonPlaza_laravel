<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaynowPayment;
use App\Services\OrderService;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Paynow\Payments\Paynow;
use Ramsey\Uuid\Uuid;
use function now;
use function redirect;
use function session;

class PaynowController extends Controller
{
    protected Paynow $paynow;

    private string $internalReference;

    public function __construct(private readonly OrderService $orderService)
    {
        $this->internalReference = Uuid::uuid4()->toString();

        Session::put('internal_reference', $this->internalReference);

        $this->paynow = new Paynow(
            config('services.paynow.integration_id'),
            config('services.paynow.integration_key'),
            url()->query('/payment/update', ['reference' => $this->internalReference]),
            url()->query('/payment/return', ['reference' => $this->internalReference])  // Customer will be redirected here after payment
        );
    }

    public function initiate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        Session::put('payment_method', 'paynow');

        if (! $this->orderService->createOrder()) {
            return redirect()->back()->with('error', 'Failed to create order!');
        }

        $orderId = Session::get('order_id');
        $order = Order::query()->findOrFail($orderId);

        // Create payment
        $payment = $this->paynow->createPayment($this->internalReference, config('services.paynow.auth_email'));
        $payment->add('Erickson Plaza Checkout #'.$request->user_id, $request->amount);

        // Create pending payment record
        PaynowPayment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'reference' => $this->internalReference,
            'payment_status' => 'pending',
        ]);

        // Send to Paynow
        $response = $this->paynow->send($payment);

        if ($response->success()) {
            // Save poll url for status checks
            PaynowPayment::where('reference', $this->internalReference)
                ->update(['poll_url' => $response->pollUrl()]);

            return redirect($response->redirectUrl());
        }

        return redirect()->back()->with('error', 'Failed to initiate payment');
    }

    public function update(Request $request)
    {
        $payment = PaynowPayment::query()
            ->where('reference', $request->query('reference'))
            ->firstOrFail();

        if ($payment && $payment->poll_url) {
            $status = $this->paynow->pollTransaction($payment->poll_url);

            if ($status->paid()) {
                $payment->update([
                    'payment_status' => 'paid',
                    'payment_method' => $status->data()['method'] ?? null,
                    'paynow_response' => $status->data(),
                    'paid_at' => now(),
                ]);

                $update = [
                    'payment_approve_date' => Carbon::now()->toDateTimeString(),
                    'payment_status' => 'paid',
                    'payment_method' => $status->data()['method'] ?? 'paynow',
                    'transaction_id' => $status->data()['paynowreference']
                ];

                $payment->order->fill($update)->saveQuietly();

                Cart::destroy();

                return redirect(route('home'))
                    ->with('success', 'Payment was successfully');
            }
        }

        return response()->json(['status' => 'pending']);
    }

    public function return(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('home');
    }
}
