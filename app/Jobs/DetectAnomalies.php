<?php
namespace App\Jobs;

use App\Models\Product;
use App\Models\Anomaly;
use App\Models\User;
use App\Notifications\AnomalyDetectedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\SettingsHelper;

class DetectAnomalies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void {
        $threshold = (float) SettingsHelper::get('anomaly_threshold', 2.0);
        $startDate = now()->subDays(30);

        Product::query()
            ->with(['sales' => function ($query) use ($startDate) {
                $query->select('product_id', 'quantity', 'created_at')
                      ->where('created_at', '>=', $startDate)
                      ->orderBy('created_at', 'asc');
            }])
            ->chunkById(100, function ($products) use ($threshold) {
                foreach ($products as $product) {
                    $salesQuantities = $product->sales->pluck('quantity')->toArray();
                    if (count($salesQuantities) < 7) continue;
                    
                    $mean = array_sum($salesQuantities) / count($salesQuantities);
                    $stddev = $this->calculateStdDev($salesQuantities, $mean);
                    if ($stddev == 0) continue;

                    $zScore = (end($salesQuantities) - $mean) / $stddev;
                    
                    if (abs($zScore) > $threshold) {
                        $anomaly = Anomaly::create([
                            'product_id' => $product->id, 
                            'z_score' => $zScore,
                            'message' => "Sales anomaly detected: " . ($zScore > 0 ? "spike" : "drop"),
                        ]);

                        // Notify all admin users about the anomaly
                        $admins = User::role('admin')->get();
                        foreach ($admins as $admin) {
                            $admin->notify(new AnomalyDetectedNotification($anomaly));
                        }
                    }
                }
            });
    }

    private function calculateStdDev(array $data, float $mean): float {
        $count = count($data);
        if ($count < 2) return 0.0;
        $sumOfSquares = array_reduce($data, fn($carry, $item) => $carry + pow($item - $mean, 2), 0);
        return sqrt($sumOfSquares / ($count - 1));
    }
}