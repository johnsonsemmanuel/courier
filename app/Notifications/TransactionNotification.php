<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Transaction $transaction
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $type = ucfirst($this->transaction->transaction_type);
        $amount = '$' . number_format($this->transaction->amount, 2);
        
        $message = (new MailMessage)
            ->subject($type . ' Confirmation - ' . $amount)
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('Your ' . strtolower($type) . ' transaction has been processed.');

        $message->line('**Transaction Details:**')
            ->line('Type: ' . $type)
            ->line('Amount: ' . $amount)
            ->line('Reference: ' . $this->transaction->reference_number)
            ->line('Status: ' . ucfirst($this->transaction->status))
            ->line('Date: ' . $this->transaction->created_at->format('F d, Y h:i A'));

        if ($this->transaction->description) {
            $message->line('Description: ' . $this->transaction->description);
        }

        if ($this->transaction->status === 'pending') {
            $message->line('⏳ This transaction is pending approval and will be processed shortly.');
        }

        $message->action('View Transaction History', url('/transactions'))
            ->line('If you did not authorize this transaction, please contact us immediately at support@couriersavingsbank.com')
            ->salutation('Best regards, The Courier Savings Bank Team');

        return $message;
    }
}
