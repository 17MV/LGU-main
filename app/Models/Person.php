<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'full_name',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'birthdate',
        'purok_no',
        'organization',
        'leader_id',
        'status',
    ];

    // Relationship: Each person belongs to a barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    // Relationship: Each person belongs to one leader
    public function leader()
    {
        return $this->belongsTo(Leader::class);
    }
}
