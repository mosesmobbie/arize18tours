<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'image', 'short_description', 'description', 'meta_description', 'meta_keywords'];

    public function getService(Service $service)
    {
        return $service;
    }
}
