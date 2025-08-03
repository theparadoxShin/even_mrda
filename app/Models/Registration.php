<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'payment_status',
        'payment_id',
        'confirmation_qr'
    ];

    // Relation to Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Get all the named attributes
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
