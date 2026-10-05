<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $q = Shipment::query()->latest();
        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('tracking_number', 'like', "%$s%")->orWhere('customer_name', 'like', "%$s%"));
        }
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        return view('admin.shipments.index', ['shipments' => $q->paginate(20)->withQueryString()]);
    }

    public function create()
    {
        return view('admin.shipments.form', ['shipment' => new Shipment(['mode' => 'sea', 'status' => 'booked'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, null);
        $data['tracking_number'] = $data['tracking_number'] ?: Shipment::generateTrackingNumber();
        $data['tracking_number'] = strtoupper($data['tracking_number']);

        $shipment = Shipment::create($data);
        $shipment->events()->create([
            'status' => $shipment->status,
            'location' => $shipment->current_location ?: $shipment->origin,
            'note' => 'Shipment created',
            'occurred_at' => now(),
        ]);

        return redirect()->route('admin.shipments.show', $shipment)->with('success', "Shipment {$shipment->tracking_number} created.");
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('events');
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.shipments.form', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $data = $this->validated($request, $shipment);
        $data['tracking_number'] = strtoupper($data['tracking_number'] ?: $shipment->tracking_number);
        $shipment->update($data);
        return redirect()->route('admin.shipments.show', $shipment)->with('success', 'Shipment updated.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('admin.shipments.index')->with('success', 'Shipment deleted.');
    }

    public function storeEvent(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Shipment::STATUSES))],
            'location' => 'nullable|string|max:160',
            'note' => 'nullable|string|max:255',
            'occurred_at' => 'required|date',
        ]);

        $shipment->events()->create($data);
        $shipment->update(['status' => $data['status'], 'current_location' => $data['location'] ?: $shipment->current_location]);

        return back()->with('success', 'Tracking update added. Customers can now see it.');
    }

    public function destroyEvent(Shipment $shipment, ShipmentEvent $event)
    {
        abort_unless($event->shipment_id === $shipment->id, 404);
        $event->delete();
        return back()->with('success', 'Tracking update removed.');
    }

    private function validated(Request $request, ?Shipment $shipment): array
    {
        return $request->validate([
            'tracking_number' => ['nullable', 'string', 'max:40', Rule::unique('shipments', 'tracking_number')->ignore($shipment?->id)],
            'customer_name' => 'required|string|max:160',
            'customer_email' => 'nullable|email|max:160',
            'mode' => ['required', Rule::in(array_keys(Shipment::MODES))],
            'origin' => 'required|string|max:160',
            'destination' => 'required|string|max:160',
            'description' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(array_keys(Shipment::STATUSES))],
            'current_location' => 'nullable|string|max:160',
            'eta' => 'nullable|date',
        ]);
    }
}
