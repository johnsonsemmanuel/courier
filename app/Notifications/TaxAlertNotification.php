<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaxAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public bool $hasObligation,
        public ?float $taxAmount = null,
        public ?string $notes = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if ($this->hasObligation) {
            $message = (new MailMessage)
                ->subject('URGENT: IRS Tax Obligation Notice')
                ->greeting('Hello, ' . $notifiable->name)
                ->line('⚠️ **IMPORTANT NOTICE**')
                ->line('Your account has been flagged for pending tax obligations with the IRS.')
                ->line('**Account Status:**')
                ->line('• All transactions are currently BLOCKED')
                ->line('• You cannot make deposits or withdrawals')
                ->line('• You cannot send or receive money')
                ->line('• You cannot make bill payments');

            if ($this->taxAmount) {
                $message->line('**Tax Amount Owed:** $' . number_format($this->taxAmount, 2));
            }

            if ($this->notes) {
                $message->line('**Additional Information:**')
                    ->line($this->notes);
            }

            $message->line('**Required Action:**')
                ->line('You must contact our customer support team immediately to resolve this matter.')
                ->line('📧 Email: support@couriersavingsbank.com')
                ->line('Please have your User ID (' . $notifiable->user_id . ') ready when contacting support.')
                ->line('⚠️ Your account will remain blocked until this issue is resolved.')
                ->salutation('Best regards, The Courier Savings Bank Compliance Team');
        } else {
            $message = (new MailMessage)
                ->subject('Tax Obligation Resolved - Account Restored')
                ->greeting('Hello, ' . $notifiable->name)
                ->line('✅ Good news! Your tax obligation has been resolved.')
                ->line('**Account Status:**')
                ->line('• Your account is now fully active')
                ->line('• All transaction restrictions have been lifted')
                ->line('• You can now use all banking services')
                ->action('Access Your Dashboard', url('/dashboard'))
                ->line('Thank you for resolving this matter promptly.')
                ->line('If you have any questions, please contact us at support@couriersavingsbank.com')
                ->salutation('Best regards, The Courier Savings Bank Team');
        }

        return $message;
    }
}
