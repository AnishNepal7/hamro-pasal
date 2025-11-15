@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Product Forecasts</h1>

    <div class="flex items-center gap-4 mb-4">
        <input id="search" type="text" placeholder="Search product by name" class="border rounded px-3 py-2 w-1/3" />
        <label>Per page:
            <select id="perPage" class="border rounded px-2 py-1 ml-2">
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select>
        </label>
        <button id="refresh" class="bg-blue-500 text-white px-3 py-1 rounded">Refresh</button>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200" id="forecastTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Weekly Sales Forecast</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Weekly Revenue Forecast</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200"></tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4">
        <div id="pagingInfo" class="text-sm text-gray-600"></div>
        <div>
            <button id="prevPage" class="px-3 py-1 border rounded mr-2">Prev</button>
            <button id="nextPage" class="px-3 py-1 border rounded">Next</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Endpoint - adjust if your route differs. The controller currently exposes '/forcastAllProdcuts' or similar;
    // The user requested '/forecast-all-product' — ensure a route exists that points to the controller method.
    const ENDPOINT = '/forecast-all-product';

    let rawResults = []; // array of {product_id, product_name, sales_forecast, revenue_forecast}
    let filtered = [];
    let currentPage = 1;
    let perPage = parseInt(document.getElementById('perPage').value || 10, 10);

    function safeNumber(v) {
        if (v === null || v === undefined) return 0;
        if (typeof v === 'number') return v;
        const n = Number(v);
        return isNaN(n) ? 0 : n;
    }

    function extractWeekly(obj, keys) {
        // Try several likely property names
        if (!obj) return 0;
        for (const k of keys) {
            if (obj[k] !== undefined) return safeNumber(obj[k]);
            if (obj.data && obj.data[k] !== undefined) return safeNumber(obj.data[k]);
            if (obj.payload && obj.payload[k] !== undefined) return safeNumber(obj.payload[k]);
        }
        // if object is a number-like
        if (typeof obj === 'number') return obj;
        if (obj.forecast !== undefined) return safeNumber(obj.forecast);
        return 0;
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';

        perPage = parseInt(document.getElementById('perPage').value || 10, 10);
        const start = (currentPage - 1) * perPage;
        const pageItems = filtered.slice(start, start + perPage);

        for (const row of pageItems) {
            const weeklySales = extractWeekly(row.sales_forecast, ['weekly_sales_forecast','weekly_sales_total','weekly_sales','weekly_sales_forecast','weekly_sales_total','weekly_forecast','forecast']);
            const weeklyRev = extractWeekly(row.revenue_forecast, ['weekly_revenue_forecast','weekly_revenue_total','weekly_revenue','weekly_rev','weekly_revenue_forecast','weekly_revenue_total','weekly_forecast','forecast']);

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${row.product_id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${row.product_name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${weeklySales.toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${weeklyRev.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
        }

        const info = document.getElementById('pagingInfo');
        const from = filtered.length === 0 ? 0 : start + 1;
        const to = Math.min(filtered.length, start + perPage);
        info.textContent = `Showing ${from} to ${to} of ${filtered.length} products`;
    }

    function applySearch() {
        const q = (document.getElementById('search').value || '').toLowerCase().trim();
        if (!q) filtered = rawResults.slice();
        else filtered = rawResults.filter(r => (r.product_name || '').toLowerCase().includes(q));
        currentPage = 1;
        renderTable();
    }

    async function fetchForecasts() {
        document.getElementById('refresh').disabled = true;
        try {
            const res = await fetch(ENDPOINT, { headers: { 'Accept': 'application/json' }});
            if (!res.ok) throw new Error('Network response was not ok');
            const data = await res.json();

            // data might be object keyed by id or {count, results} etc.
            let list = [];
            if (Array.isArray(data)) list = data;
            else if (data.results && Array.isArray(data.results)) list = data.results;
            else if (typeof data === 'object') {
                // if keyed by id
                list = Object.keys(data).map(k => data[k]);
            }

            // normalize entries to have product_id and product_name
            rawResults = list.map(item => {
                return {
                    product_id: item.product_id ?? item.id ?? null,
                    product_name: item.product_name ?? item.name ?? (item.payload && item.payload.sales && item.payload.sales[0] ? item.payload.sales[0].product_name : null) ?? '',
                    sales_forecast: item.sales_forecast ?? item.sales ?? null,
                    revenue_forecast: item.revenue_forecast ?? item.revenue ?? null,
                };
            });

            filtered = rawResults.slice();
            currentPage = 1;
            renderTable();
        } catch (err) {
            console.error('Failed to load forecasts', err);
            alert('Failed to load forecasts: ' + err.message);
        } finally {
            document.getElementById('refresh').disabled = false;
        }
    }

    // hooks
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('search').addEventListener('input', () => applySearch());
        document.getElementById('perPage').addEventListener('change', () => renderTable());
        document.getElementById('prevPage').addEventListener('click', () => { if (currentPage>1) { currentPage--; renderTable(); } });
        document.getElementById('nextPage').addEventListener('click', () => { if ((currentPage*perPage) < filtered.length) { currentPage++; renderTable(); } });
        document.getElementById('refresh').addEventListener('click', fetchForecasts);

        fetchForecasts();
    });
</script>
@endpush

@endsection
