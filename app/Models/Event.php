<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Indicate which attributes are mass assignable
    protected $fillable = [
        'name',
        'description',
        'price',
        'event_date',
        'qr_code',
        'is_active'
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    /**
     * Get the registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get the active registrations for the event.
     */

    public function getPaidRegistrationsAttribute()
    {
        return $this->registrations()->where('payment_status', 'paye')->count();
    }


    /**
     * Get the inactive registrations for the event.
     */

    public function getUnpaidRegistrationsAttribute()
    {
        return $this->registrations()->where('payment_status', 'non_paye')->count();
    }

    /**
     * Get the total registrations for the event.
     */
    public function getTotalRegistrationsAttribute()
    {
        return $this->registrations()->count();
    }

}
