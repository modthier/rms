<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'contact_name',
        'email',
        'phone',
        'tax_number',
        'address',
    ];

    public function bulkInvoices(): HasMany
    {
        return $this->hasMany(BulkInvoice::class);
    }
}
