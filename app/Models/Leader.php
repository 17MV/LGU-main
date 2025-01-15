<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'name',
    ];

    // Relationship: Each leader belongs to a barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    // Relationship: Each leader has many persons
    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
