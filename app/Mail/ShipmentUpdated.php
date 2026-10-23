<?php

namespace App\Mail;
use App\Models\Shipment;
use App\Models\ShipmentEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShipmentUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
 public function __construct(
        public Shipment $shipment,
        public ShipmentEvent $event
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
  public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Shipment Update: {$this->shipment->tracking_number}",
        );
    }

    /**
     * Get the message content definition.
     */
public function content(): Content
    {
        return new Content(
            view: 'emails.shipments.updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
