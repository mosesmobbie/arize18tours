<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use stdClass;

class ContactDetails extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value', 'active'];
}
