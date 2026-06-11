<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_type',
        'vehicle_type',
        'name',
        'email',
        'phone',
        'pickup_address',
        'dropoff_address',
        'pickup_time',
        'dropoff_time',
        'passengers',
        'transmission',
        'flight_number',
        'reservation_number',
        'id_number',
        'notes',
        'status'
    ];
}
