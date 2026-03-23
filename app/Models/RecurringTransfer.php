<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class RecurringTransfer extends Model
{
    protected $fillable = [
        'user_id',
        'recipient_account',
        'recipient_name',
        'amount',
        'frequency',
        'start_date',
        'end_date',
        'next_execution_date',
        'description',
        'status',
        'execution_count',
        'max_executions',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'next_execution_date' => 'date',
        'execution_count' => 'integer',
        'max_executions' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateNextExecutionDate(): Carbon
    {
        $current = $this->next_execution_date;
        
        return match($this->frequency) {
            'daily' => $current->addDay(),
            'weekly' => $current->addWeek(),
            'biweekly' => $current->addWeeks(2),
            'monthly' => $current->addMonth(),
            'quarterly' => $current->addMonths(3),
            'yearly' => $current->addYear(),
            default => $current->addMonth(),
        };
    }

    public function shouldExecute(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->next_execution_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->next_execution_date->isAfter($this->end_date)) {
            return false;
        }

        if ($this->max_executions && $this->execution_count >= $this->max_executions) {
            return false;
        }

        return true;
    }
}
