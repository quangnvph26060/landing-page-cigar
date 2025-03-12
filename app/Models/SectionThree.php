<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionThree extends Model
{
    use HasFactory;

    public $fillable = [
        'orders',
        'reviews',
        'end_date',
        'bg_image',
        'content'
    ];

    protected $casts = [
        'content' => 'array',
        'end_date' => 'date'
    ];
}
