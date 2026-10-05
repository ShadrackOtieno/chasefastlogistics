<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentEvent extends Model
{
    protected $guarded = [];
    protected $casts = ['occurred_at' => 'datetime'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
