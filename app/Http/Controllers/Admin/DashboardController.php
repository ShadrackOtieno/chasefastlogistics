<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\QuoteRequest;
use App\Models\Shipment;
use App\Models\ShipmentEvent;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'newQuotes' => QuoteRequest::where('status', 'new')->count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'active' => Shipment::where('status', '!=', 'delivered')->count(),
            'totalShipments' => Shipment::count(),
            'quotes' => QuoteRequest::latest()->take(6)->get(),
            'messages' => ContactMessage::latest()->take(6)->get(),
            'events' => ShipmentEvent::with('shipment')->latest('occurred_at')->take(6)->get(),
        ]);
    }
}
