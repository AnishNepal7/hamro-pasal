@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-bold metallic-text-gold font-orbitron">PRODUCT FORECASTS</h2>
        <a href="/dashboard" class="metallic-btn px-8 py-4 text-lg font-bold rounded-lg text-metallic-light hover:text-white transition-colors duration-300">
            ← Return to Dashboard
        </a>
    </div>

    {{-- Loading Indicator --}}
    <div id="loading" class="flex justify-center items-center py-16">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-gray-300 border-t-yellow-400"></div>
    </div>

    {{-- Forecast Table --}}
    <div id="forecastContent" class="metallic-card p-8 rounded-xl hidden">
        <div class="overflow-x-auto">
            <table class="metallic-table min-w-full rounded-lg overflow-hidden border">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left">Product ID</th>
                        <th class="px-6 py-4 text-left">Product Name</th>
                        <th class="px-6 py-4 text-center">Weekly Sales Forecast</th>
                        <th class="px-6 py-4 text-center">Weekly Revenue Forecast</th>
                    </tr>
                </thead>
                <tbody id="forecastTableBody">
                    {{-- AJAX will populate this --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- jQuery for fetching forecast --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        url: "/forecast-all-products",
        type: "GET",
        dataType: "json",
        success: function(data) {
            let tbody = $("#forecastTableBody");
            tbody.empty();

            // Convert object to array
            let list = Object.values(data);

            $.each(list, function(key, item) {
                // Skip products without forecast
                let salesForecast = item.sales_forecast?.weekly_sales_forecast ?? 'No data';
                let revenueForecast = item.revenue_forecast?.weekly_revenue_forecast ?? 'No data';

                // Skip invalid products
                if (!item.product_id || !item.product_name) return;

                let row = `
                    <tr class="hover:bg-steel-700/30 transition-colors duration-200">
                        <td class="px-6 py-4 text-lg font-mono">${item.product_id}</td>
                        <td class="px-6 py-4 text-lg font-semibold">${item.product_name}</td>
                        <td class="px-6 py-4 text-center text-lg">${salesForecast}</td>
                        <td class="px-6 py-4 text-center text-lg">${revenueForecast}</td>
                    </tr>
                `;
                tbody.append(row);
            });

            // Hide loader and show table
            $("#loading").hide();
            $("#forecastContent").removeClass("hidden");
        },
        error: function(xhr) {
            $("#loading").html(`<div class="text-red-400 text-lg">Error loading forecast data!</div>`);
            console.error("Error:", xhr.responseText);
        }
    });
});
</script>
@endsection
