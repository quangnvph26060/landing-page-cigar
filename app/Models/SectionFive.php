<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionFive extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'albums'
    ];

    protected $casts = [
        'albums' => 'array'
    ];
}
