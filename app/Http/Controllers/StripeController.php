<?php

namespace App\Http\Controllers;


use App\Models\StripeSession;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function test()
    {
//        dd(config('stripe.test.sk'));

        Stripe::setApiKey(config('stripe.test.sk'));

        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'azn',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount' => 500,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('checkout'),
        ]);

//        dd($session);

        StripeSession::create([
            'session_id'=>$session->id,
            'payment_status'=>$session->payment_status,
            'amount_total'=>$session->amount_total,
            'currency'=>'azn'
        ]);
        return redirect()->away($session->url);

    }

}
