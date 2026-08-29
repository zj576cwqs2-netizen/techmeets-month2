<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $secret = config('services.stripe.secret');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency'     => 'jpy',
                    'product_data' => ['name' => '商品名'],
                    'unit_amount'  => 1000,  // 1,000円
                ],
                'quantity' => 1
            ]],
            'mode'        => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('checkout.cancel'),
        ], [
            'api_key' => $secret,
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        return view('checkout.success');
    }
}