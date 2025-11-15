<?php
namespace App\Notifications;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;
    public Product $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function via($notifiable): array {
        return ['database','mail']; // Store in the DB to be shown in-app
    }
     // Email message
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Low Stock Alert: ' . $this->product->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("The stock for product **{$this->product->name}** is running low.")
            ->line("Current stock: **{$this->product->current_stock} units.**")
            ->action('Restock product', url("/products/{$this->product->id}/edit"))
            ->line('Please restock soon to avoid running out of inventory.');
    }


    public function toArray($notifiable): array {
        return [
            'type' => 'danger', // For styling the alert box
            'message' => "Low stock alert: '{$this->product->name}' is at {$this->product->current_stock} units.",
            'product_id' => $this->product->id,
        ];
    }
}