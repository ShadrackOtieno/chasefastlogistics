<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $guarded = [];

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'quoted' => 'Quoted',
        'won' => 'Won',
        'lost' => 'Lost',
    ];

    public const SERVICE_TYPES = [
        'Air Freight', 'Sea Freight', 'Overland Transport',
        'Customs Clearance', 'Warehousing', 'Project Forwarding', 'Other',
    ];
}
