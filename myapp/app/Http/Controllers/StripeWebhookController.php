<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (UnexpectedValueException $e) {
            Log::warning('Stripe Webhook: invalid payload', [
                'error' => $e->getMessage(),
            ]);
            return response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            Log::warning('Stripe Webhook: signature verification failed', [
                'error' => $e->getMessage(),
            ]);
            return response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;

                Log::info('Stripe決済完了', [
                    'payment_intent_id' => $paymentIntent->id,
                    'amount'             => $paymentIntent->amount,
                    'currency'           => $paymentIntent->currency,
                ]);

                // 購入履歴をDBに保存(同じpayment_intent_idが来ても重複登録しない)
                Purchase::firstOrCreate(
                    ['payment_intent_id' => $paymentIntent->id],
                    [
                        'amount'   => $paymentIntent->amount,
                        'currency' => $paymentIntent->currency,
                        'status'   => 'succeeded',
                    ]
                );

                break;

            default:
                Log::info('Stripe Webhook: 未処理のイベントタイプ', [
                    'type' => $event->type,
                ]);
        }

        return response('Webhook handled', 200);
    }
}
