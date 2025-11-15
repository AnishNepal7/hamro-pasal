<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background: #eee; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Sales Report</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Total Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->sale_date}}</td>
                <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                <td>
                    @foreach($sale->saleItems as $item)
                        {{ $item->product->name }} × {{ $item->quantity }} <br>
                    @endforeach
                </td>
                <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- total revenue -->
    <h3 style="text-align: right; margin-top: 20px;">
        Total Revenue: Rs. {{ number_format($sales->sum('total_amount'), 2) }}
    </h3>
    
</body>
</html>
