<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    // Specifies the attributes that can be mass assigned
    protected $fillable = ['barangay_id', 'name'];

    // Defines the relationship between Leader and Barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}

