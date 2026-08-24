<?php

namespace App\Services;

use SendGrid\Mail\Mail;
use SendGrid;
use Illuminate\Support\Facades\Log;

class SendGridMailer
{
    public function sendWelcomeEmail(string $toEmail, string $toName): bool
    {
        $email = new Mail();
        $email->setFrom(config('mail.from.address'), config('mail.from.name'));
        $email->setSubject('ご登録ありがとうございます');
        $email->addTo($toEmail, $toName);
        $email->addContent(
            'text/plain',
            "{$toName} 様\n\nご登録ありがとうございます。これからよろしくお願いいたします。"
        );
        $email->addContent(
            'text/html',
            "<p>{$toName} 様</p><p>ご登録ありがとうございます。これからよろしくお願いいたします。</p>"
        );

        $sendgrid = new SendGrid(config('services.sendgrid.api_key'));

        try {
            $response = $sendgrid->send($email);
            Log::info('SendGrid: ウェルカムメール送信成功', [
                'to' => $toEmail,
                'status_code' => $response->statusCode(),
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('SendGrid: メール送信失敗', [
                'to' => $toEmail,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
