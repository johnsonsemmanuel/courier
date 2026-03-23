<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountFrozenNotification extends Notification
{
    use Queueable;

    public function __construct(
        public bool $isFrozen,
        public ?string $reason = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if ($this->isFrozen) {
            $message = (new MailMessage)
                ->subject('Important: Your Account Has Been Frozen')
                ->greeting('Hello, ' . $notifiable->name)
                ->line('⚠️ Your account has been temporarily frozen.')
                ->line('**What this means:**')
                ->line('• You cannot make deposits or withdrawals')
                ->line('• You cannot send or receive money')
                ->line('• You cannot make bill payments')
                ->line('• Your virtual cards are temporarily disabled');

            if ($this->reason) {
                $message->line('**Reason:** ' . $this->reason);
            }

            $message->line('**Next Steps:**')
                ->line('Please contact our support team immediately to resolve this issue.')
                ->line('📧 Email: support@couriersavingsbank.com')
                ->line('We apologize for any inconvenience and are here to help you resolve this quickly.')
                ->salutation('Best regards, The Courier Savings Bank Team');
        } else {
            $message = (new MailMessage)
                ->subject('Good News: Your Account Has Been Unfrozen')
                ->greeting('Hello, ' . $notifiable->name)
                ->line('✅ Your account has been unfrozen and is now active.')
                ->line('You can now:')
                ->line('• Make deposits and withdrawals')
                ->line('• Send and receive money')
                ->line('• Make bill payments')
                ->line('• Use your virtual cards')
                ->action('Access Your Dashboard', url('/dashboard'))
                ->line('Thank you for your patience. If you have any questions, please contact us at support@couriersavingsbank.com')
                ->salutation('Best regards, The Courier Savings Bank Team');
        }

        return $message;
    }
}
