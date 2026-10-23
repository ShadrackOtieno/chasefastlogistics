<div>
    <h2>Hello {{ $shipment->customer_name }},</h2>
    <p>Your shipment has been successfully booked/created.</p>

    <p><strong>Tracking Number:</strong> {{ $shipment->tracking_number }}</p>
    <p><strong>Origin:</strong> {{ $shipment->origin }}</p>
    <p><strong>Destination:</strong> {{ $shipment->destination }}</p>
    <p><strong>Status:</strong> {{ $shipment->statusLabel() }}</p>

    <p>You can use this tracking code to check the real-time status and updates of your shipment on our website at <a href="https://chasefastlogistics.com" target="_blank">chasefastlogistics.com</a> by clicking on the <strong>"Track Shipment"</strong> link in the header.</p>

    <p>Thank you for choosing our service!</p>
</div>
