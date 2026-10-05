<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $guarded = [];
    protected $casts = ['eta' => 'date'];

    public const STATUSES = [
        'booked' => 'Booked',
        'in_transit' => 'In Transit',
        'arrived' => 'Arrived at Port / Airport',
        'customs_clearance' => 'Customs Clearance',
        'cleared' => 'Cleared',
        'out_for_delivery' => 'Out for Delivery',
        'delivered' => 'Delivered',
        'delayed' => 'Delayed',
    ];

    public const MODES = ['air' => 'Air', 'sea' => 'Sea', 'land' => 'Land'];

    public function events()
    {
        return $this->hasMany(ShipmentEvent::class)->orderByDesc('occurred_at')->orderByDesc('id');
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public static function generateTrackingNumber(): string
    {
        do {
            $n = 'CFL'.date('y').random_int(100000, 999999);
        } while (static::where('tracking_number', $n)->exists());
        return $n;
    }
}
