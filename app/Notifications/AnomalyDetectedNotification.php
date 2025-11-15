<?php
namespace App\Notifications;

use App\Models\Anomaly;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnomalyDetectedNotification extends Notification
{
    use Queueable;
    public Anomaly $anomaly;

    public function __construct(Anomaly $anomaly)
    {
        $this->anomaly = $anomaly;
    }

    public function via($notifiable): array
    {
        return ['database']; // Store in the DB
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'warning', // For styling the alert box
            'message' => "Sales anomaly for '{$this->anomaly->product->name}': {$this->anomaly->message}.",
            'product_id' => $this->anomaly->product_id,
        ];
    }
}