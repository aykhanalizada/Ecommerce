<?php

namespace App\Http\Controllers;

use App\Models\StripeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{

    public function handle(Request $request)
    {
        $event = $request->all();

        if ($event['type'] == 'checkout.session.completed') {
            $sessionId = $event['data']['object']['id'];

            $stripeSession = StripeSession::where('session_id', $sessionId)->first();

            if ($stripeSession) {
                $stripeSession->update([
                    'payment_status' => 'succeeded'
                ]);
            }

        }

        return response('Webhook Handled', 200);
    }


}
