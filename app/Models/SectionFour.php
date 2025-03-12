<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionFour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'album_slider',
        'options'
    ];

    protected $casts = [
        'album_slider' => 'array',
        'options' => 'array',
    ];
}
