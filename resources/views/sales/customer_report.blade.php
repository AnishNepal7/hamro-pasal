<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Customer Sales Report</title>
<style>
body { font-family: sans-serif; font-size: 13px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #666; padding: 6px; text-align: center; }
th { background: #ddd; }
h2 { text-align: center; }
</style>
</head>
<body>

<h2>SALES REPORT – {{ $customer->name }}</h2>
<p><b>From:</b> {{ $request->from_date }} &nbsp; <b>To:</b> {{ $request->to_date }}</p>

<table>
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Products</th>
<th>Total Amount (Rs.)</th>
</tr>
</thead>

<tbody>
@foreach($sales as $sale)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $sale->sale_date }}</td>
<td>
@foreach($sale->saleItems as $item)
{{ $item->product->name }} × {{ $item->quantity }} <br>
@endforeach
</td>
<td>{{ number_format($sale->total_amount,2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<br>
<h3 style="text-align:right;">
Total Revenue: Rs. {{ number_format($sales->sum('total_amount'),2) }}
</h3>

</body>
</html>
