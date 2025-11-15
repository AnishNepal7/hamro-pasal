<?php
namespace App\Jobs;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckLowStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void {
        // Find all products below their reorder level
        $lowStockProducts = Product::whereRaw('current_stock <= reorder_level')->get();
        
        // For simplicity, we notify all admins. 
        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();

        foreach ($lowStockProducts as $product) {
            foreach ($admins as $admin) {
                $admin->notify(new LowStockNotification($product));
            }
        }
    }
}