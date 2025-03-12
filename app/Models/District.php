<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'district';

    protected $fillable = [
        'province_id',
        'name'
    ];

    public function ward()
    {
        return $this->hasOne(Ward::class, 'district_id');
    }
}
