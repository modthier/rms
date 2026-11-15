<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkInvoicePayment extends Model
{
    protected $fillable = [
        'bulk_invoice_id',
        'user_id',
        'amount',
        'paid_on',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_on' => 'date',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(BulkInvoice::class, 'bulk_invoice_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
