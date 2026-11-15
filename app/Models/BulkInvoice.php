<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BulkInvoice extends Model
{
    protected $fillable = [
        'company_id',
        'user_id',
        'invoice_number',
        'issued_on',
        'due_on',
        'total',
        'notes',
    ];

    protected $casts = [
        'issued_on' => 'date',
        'due_on' => 'date',
        'total' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BulkInvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BulkInvoicePayment::class);
    }

    public function getPaidAmountAttribute(): string
    {
        $paid = $this->getAttribute('payments_sum_amount');

        if ($paid === null) {
            $paid = $this->relationLoaded('payments')
                ? $this->payments->sum('amount')
                : $this->payments()->sum('amount');
        }

        return number_format(((int) round((float) $paid * 100)) / 100, 2, '.', '');
    }

    public function getBalanceDueAttribute(): string
    {
        $balanceCents = (int) round((float) $this->total * 100)
            - (int) round((float) $this->paid_amount * 100);

        return number_format(max(0, $balanceCents) / 100, 2, '.', '');
    }

    public function getPaymentStatusAttribute(): string
    {
        if ((int) round((float) $this->paid_amount * 100) <= 0) {
            return 'unpaid';
        }

        return (int) round((float) $this->balance_due * 100) <= 0 ? 'paid' : 'partial';
    }
}
