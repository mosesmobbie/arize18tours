<?php

namespace App\Models;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'unit', 'amount', 'quotation_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function quotation(): BelongsTo {
        return $this->belongsTo(Quotation::class);
    }
}
