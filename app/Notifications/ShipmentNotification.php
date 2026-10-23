
<?php


use App\Models\Shipment;
use App\Models\ShipmentEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ShipmentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Shipment $shipment,
        public ?ShipmentEvent $event = null,
        public bool $isInitial = false
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->isInitial
            ? 'Your Shipment Reference: ' . $this->shipment->tracking_number
            : 'Shipment Tracking Update: ' . $this->shipment->tracking_number;

        $mail = (new MailMessage)
            ->subject($subject)
            ->greeting('Hello ' . $this->shipment->customer_name);

        if ($this->isInitial) {
            $mail->line('Your shipment has been registered successfully.')
                ->line('Please keep your reference number for future tracking enquiries.');
        } else {
            $mail->line('There is a new update regarding your shipment.');
        }

        $mail->line('Reference Number: ' . $this->shipment->tracking_number)
            ->line('Current Status: ' . $this->shipment->statusLabel())
            ->line('Shipping Method: ' . Str::headline($this->shipment->mode))
            ->line('Origin: ' . $this->shipment->origin)
            ->line('Destination: ' . $this->shipment->destination);

        if ($this->shipment->current_location) {
            $mail->line('Current Location: ' . $this->shipment->current_location);
        }

        if ($this->shipment->eta) {
            $mail->line(
                'Estimated Arrival: ' . $this->shipment->eta->format('d M Y')
            );
        }

        if ($this->event) {
            $mail->line('Latest Tracking Activity')
                ->line(
                    'Event Status: ' . Str::headline($this->event->status)
                );

            if ($this->event->location) {
                $mail->line('Event Location: ' . $this->event->location);
            }

            if ($this->event->note) {
                $mail->line('Tracking Note: ' . $this->event->note);
            }

            $mail->line(
                'Update Date: ' .
                $this->event->occurred_at->format('d M Y, H:i')
            );
        }

        return $mail
            ->line('Thank you for choosing us.')
            ->salutation(config('app.name') . ' Team');
    }
}
