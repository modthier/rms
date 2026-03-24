<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseChange extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
    
    public function expense() {
        return $this->belongsTo(DailyExpense::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function expenseType()
    {
    	return $this->belongsTo(ExpenseType::class);
    }
}
