<?php

namespace App\Mail;
use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShipmentCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
public function __construct(public Shipment $shipment)
    {
        //
    }

    /**
     * Get the message envelope.
     */
   public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your Shipment Tracking Code: {$this->shipment->tracking_number}",
        );
    }

    /**
     * Get the message content definition.
     */
  public function content(): Content
    {
        return new Content(
            view: 'emails.shipments.created',
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
