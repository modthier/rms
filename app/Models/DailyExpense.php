<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyExpense extends Model
{
	protected $fillable = [
        'title' , 'amount','expense_type_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function expenseChange() {
        return $this->hasMany(ExpenseChange::class);
    }

    public function expenseType()
    {
    	return $this->belongsTo(ExpenseType::class);
    }
}
