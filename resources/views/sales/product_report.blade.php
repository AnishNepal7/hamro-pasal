<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Product Sales Report</title>
<style>
body { font-family: sans-serif; font-size: 13px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #666; padding: 6px; text-align: center; }
th { background: #ddd; }
h2 { text-align: center; }
</style>
</head>
<body>

<h2>PRODUCT SALES REPORT</h2>

<p>
<b>Product:</b> {{ $product->name }} <br>
<b>From:</b> {{ $request->from_date }} <b>To:</b> {{ $request->to_date }}
</p>

<table>
<thead>
<tr>
<th>#</th>
<th>Date</th>
<th>Customer</th>
<th>Quantity</th>
<th>Total (Rs.)</th>
</tr>
</thead>

<tbody>
@php $totalQty = 0; @endphp
@foreach($sales as $sale)
@foreach($sale->saleItems as $item)
@if($item->product_id == $product->id)
<tr>
<td>{{ $loop->parent->iteration }}</td>
<td>{{ $sale->sale_date }}</td>
<td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ number_format($item->total,2) }}</td>
@php $totalQty += $item->quantity; @endphp
</tr>
@endif
@endforeach
@endforeach
</tbody>
</table>

<br>
<h3 style="text-align:right;">
Total Qty Sold: {{ $totalQty }}
</h3>

</body>
</html>
