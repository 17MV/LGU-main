<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // Relationship: A barangay has many persons
    public function persons()
    {
        return $this->hasMany(Person::class);
    }

    // Relationship: A barangay has many leaders
    public function leaders()
    {
        return $this->hasMany(Leader::class);
    }
}
