<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $number = strtoupper(trim((string) $request->query('number', '')));
        $shipment = null;

        if ($number !== '') {
            $shipment = Shipment::with('events')->where('tracking_number', $number)->first();
        }

        return view('site.track', ['number' => $number, 'shipment' => $shipment]);
    }
}
