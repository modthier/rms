<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirmentChange extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function requirementType() {
        return $this->belongsTo(RequirementType::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function requirment() {
        return $this->belongsTo(Requirment::class);
    }

    
}
