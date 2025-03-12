<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'province_id',
        'district_id',
        'ward_id',
        'message'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    // Quan hệ với bảng districts
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    // Quan hệ với bảng wards
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'wards_id');
    }
}
