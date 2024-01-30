<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class urlShorten extends Model
{
    use HasFactory;

    protected $fillable = [
         'title',
         'original_url',
         'shortened_url',
         'user_id',
    ];
}
