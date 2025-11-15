<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ForecastingService
{
    protected string $forecastingUrl;

    public function __construct() {
        $this->forecastingUrl = config('services.forecasting.url');
    }

    public function predict(Product $product): float {
        $salesData = $product->sales()
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at')
            ->get(['created_at', 'quantity']);

        if ($salesData->isEmpty()) {
            return 0.0;
        }

        $formattedSales = $salesData->map(function ($sale) {
            return [
                'date' => $sale->created_at->format('Y-m-d'),
                'quantity' => $sale->quantity,
            ];
        });

        try {
            $response = Http::timeout(10)->post($this->forecastingUrl . '/forecast', [
                'sales' => $formattedSales->values()
            ]);

            if ($response->failed()) {
                Log::error('Forecasting service failed.', [
                    'status' => $response->status(), 'product_id' => $product->id
                ]);
                return 0.0;
            }
            return $response->json('forecast', 0.0);

        } catch (Exception $e) {
            Log::error('Could not connect to forecasting service.', [
                'exception' => $e->getMessage(), 'product_id' => $product->id
            ]);
            return 0.0;
        }
    }
}