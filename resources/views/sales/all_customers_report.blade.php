<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>All Customers Sales Report</title>
<style>
body { font-family: sans-serif; font-size: 13px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #666; padding: 6px; text-align: center; }
th { background: #ddd; }
h2 { text-align: center; }
</style>
</head>
<body>

<h2>ALL CUSTOMERS SALES REPORT</h2>
<p>
<b>From:</b> {{ $request->from_date }} <b>To:</b> {{ $request->to_date }}
</p>

<table>
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Customer</th>
<th>Products</th>
<th>Total (Rs.)</th>
</tr>
</thead>

<tbody>
@foreach($sales as $sale)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $sale->sale_date }}</td>
<td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
<td>
@foreach($sale->saleItems as $i)
{{ $i->product->name }} × {{ $i->quantity }} <br>
@endforeach
</td>
<td>{{ number_format($sale->total_amount,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<br>
<h3 style="text-align:right;">
TOTAL REVENUE: Rs. {{ number_format($sales->sum('total_amount'),2) }}
</h3>

</body>
</html>
