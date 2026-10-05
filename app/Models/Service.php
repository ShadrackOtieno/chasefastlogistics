<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];

    /** Icon keys available in resources/views/components/icon.blade.php */
    public const ICONS = [
        'plane' => 'Plane (air freight)',
        'ship' => 'Ship (sea freight)',
        'truck' => 'Truck (overland)',
        'file-check' => 'Document (customs)',
        'warehouse' => 'Warehouse',
        'building' => 'Building (projects)',
        'globe' => 'Globe',
        'package' => 'Package',
        'layers' => 'Layers (consolidation)',
        'shield-check' => 'Shield (security)',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }

    public function featureList(): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) $this->features))));
    }
}
