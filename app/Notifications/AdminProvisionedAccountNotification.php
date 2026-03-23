<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminProvisionedAccountNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $plainPassword
    ) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Your Courier Savings Bank account')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('An administrator has created an online banking account for you.')
            ->line('You can sign in right away using the credentials below.')
            ->line('**Login email:** ' . $notifiable->email)
            ->line('**Temporary password:** ' . $this->plainPassword)
            ->action('Sign in', url(route('login')))
            ->line('For security, change your password after signing in (Profile → Change password).')
            ->salutation('Courier Savings Bank');
    }
}
