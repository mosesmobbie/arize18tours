<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
        protected $fillable = [
        'total_amount', 'deposit_amount', 'amount_paid', 'status', 'notes', 'booking_id', 'name', 'phone'
    ];

    public function items() {
        return $this->hasMany(QuoteItem::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
