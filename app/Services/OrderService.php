<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class OrderService
{
    /** Store Order in Database  */
    public function createOrder(): bool
    {
        try {
            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->internal_id = Session::get('internal_reference');
            $order->user_id = auth()->user()->id;
            $order->address = session()->get('address') ?? "No address";
            $order->discount = session()->get('coupon')['discount'] ?? 0;
            $order->delivery_charge = session()->get('delivery_fee') ?? 0;
            $order->subtotal = cartTotal();
            $order->grand_total = grandCartTotal(session()->get('delivery_fee'));
            $order->product_qty = \Cart::content()->count();
            $order->payment_method = session()->get('payment_method') ?? 'Cash';
            $order->payment_status = 'pending';
            $order->payment_approve_date = null;
            $order->transaction_id = null;
            $order->coupon_info = json_encode(session()->get('coupon')) ?? null;
            $order->currency_name = null;
            $order->order_status = 'pending';
            $order->address_id = session()->get('address_id') ?? 0;
            $order->save();

            foreach (\Cart::content() as $product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_name = $product->name;
                $orderItem->product_id = $product->id;
                $orderItem->unit_price = $product->price;
                $orderItem->qty = $product->qty;
                $orderItem->product_size = json_encode($product->options->product_size);
                $orderItem->product_option = json_encode($product->options->product_options);
                $orderItem->save();
            }

            /** Putting the Order id in session */
            session()->put('order_id', $order->id);

            /** Putting the grand total amount in session */
            session()->put('grand_total', $order->grand_total);

            return true;
        } catch (\Exception $e) {
            logger($e);

            return false;
        }
    }

    /** Clear Session Items  */
    public function clearSession()
    {
        \Cart::destroy();
        session()->forget('coupon');
        session()->forget('address');
        session()->forget('delivery_fee');
        session()->forget('delivery_area_id');
        session()->forget('order_id');
        session()->forget('grand_total');
    }
}
