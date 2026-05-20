<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $fillable = [
        'area_name',
        'charge',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'charge' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
