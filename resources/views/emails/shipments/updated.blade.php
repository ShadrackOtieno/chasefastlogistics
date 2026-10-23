<div>
    <h2>Hello {{ $shipment->customer_name }},</h2>
    <p>There is a new update regarding your shipment (<strong>{{ $shipment->tracking_number }}</strong>):</p>

    <ul>
        <li><strong>Status:</strong> {{ $shipment->statusLabel() }}</li>
        <li><strong>Location:</strong> {{ $event->location ?? 'N/A' }}</li>
        <li><strong>Note:</strong> {{ $event->note ?? 'No additional notes.' }}</li>
        <li><strong>Date/Time:</strong> {{ $event->occurred_at }}</li>
    </ul>

    <p>Thank you for staying updated with us!</p>
</div>
