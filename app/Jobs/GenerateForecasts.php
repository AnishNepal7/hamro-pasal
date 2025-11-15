<?php
namespace App\Jobs;

use App\Models\Product;
use App\Models\Forecast;
use App\Services\ForecastingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateForecasts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(ForecastingService $forecastingService): void
    {
        Log::info("Starting GenerateForecasts job.");

        Product::query()->chunkById(50, function ($products) use ($forecastingService) {
            foreach ($products as $product) {
                $prediction = $forecastingService->predict($product);

                // Store the forecast
                Forecast::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        // Assuming the forecast is for the upcoming week
                        'forecast_for_date' => now()->startOfWeek()->addWeek()->toDateString(),
                    ],
                    [
                        'predicted_quantity' => $prediction,
                    ]
                );
            }
        });

        Log::info("Finished GenerateForecasts job.");
    }
}