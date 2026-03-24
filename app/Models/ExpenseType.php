<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;
    protected $fillable = [
       'name'
    ];
    public function dailyExpense() {
        return $this->hasMany(DailyExpense::class);
    }

    public function expenseChange() {
        return $this->hasMany(ExpenseChange::class);
    }
}
