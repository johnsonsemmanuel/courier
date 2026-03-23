<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $user,
        public Account $account
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Courier Savings Bank!')
            ->greeting('Welcome, ' . $this->user->name . '!')
            ->line('Your account has been successfully created.')
            ->line('**Account Details:**')
            ->line('User ID: ' . $this->user->user_id)
            ->line('Account Number: ' . $this->account->account_number)
            ->line('Account Name: ' . $this->account->account_name)
            ->line('Account Type: ' . ucfirst($this->account->account_type))
            ->action('Access Your Dashboard', url('/dashboard'))
            ->line('Thank you for choosing Courier Savings Bank. We\'re here to make banking simple and secure.')
            ->line('If you have any questions, please contact us at support@couriersavingsbank.com')
            ->salutation('Best regards, The Courier Savings Bank Team');
    }
}
