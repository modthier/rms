<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'total_price' => 'decimal:2',
        'quantity' => 'decimal:3',
    ];

    public function requirementType() {
        return $this->belongsTo(RequirementType::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function requirementChange() {
        return $this->hasMany(RequirmentChange::class);
    }
}
