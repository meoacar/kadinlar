<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the verification email notification mail message for the given URL.
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('E-posta Adresinizi Doğrulayın')
            ->line('Lütfen e-posta adresinizi doğrulamak için aşağıdaki butona tıklayın:')
            ->action('E-postayı Doğrula', $url)
            ->line('Eğer bu işlemi siz başlatmadıysanız, lütfen bu e-postayı dikkate almayın.');
    }
}
