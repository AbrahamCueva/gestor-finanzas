<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationService
{
    public function enviar(User $user, string $titulo, string $cuerpo, string $url = '/admin'): void
    {
        $suscripciones = PushSubscription::where('user_id', $user->id)->get();

        if ($suscripciones->isEmpty()) return;

        $auth = [
            'VAPID' => [
                'subject'    => config('services.vapid.subject'),
                'publicKey'  => config('services.vapid.public_key'),
                'privateKey' => config('services.vapid.private_key'),
            ],
        ];

        $webPush = new WebPush($auth);

        $payload = json_encode([
            'title'   => $titulo,
            'body'    => $cuerpo,
            'icon'    => '/icons/icon-192.png',
            'badge'   => '/icons/icon-96.png',
            'data'    => ['url' => $url],
            'tag'     => 'ricox-' . time(),
        ]);

        foreach ($suscripciones as $sub) {
            try {
                $subscription = Subscription::create([
                    'endpoint'        => $sub->endpoint,
                    'publicKey'       => $sub->public_key,
                    'authToken'       => $sub->auth_token,
                    'contentEncoding' => 'aesgcm',
                ]);

                $webPush->queueNotification($subscription, $payload);
            } catch (\Exception $e) {
                $sub->delete();
            }
        }

        foreach ($webPush->flush() as $report) {
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $report->getRequest()->getUri()->__toString())->delete();
            }
        }
    }

    public function enviarATodos(string $titulo, string $cuerpo, string $url = '/admin'): void
    {
        $usuarios = User::all();
        foreach ($usuarios as $user) {
            $this->enviar($user, $titulo, $cuerpo, $url);
        }
    }
}
