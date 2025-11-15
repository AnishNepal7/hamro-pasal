<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice #{{ $sale->id }}</title>
<style>
body { font-family: sans-serif; font-size: 13px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #333; padding: 6px; text-align: center; }
th { background: #e8e8e8; }
h2, h3 { text-align: center; margin: 4px 0; }
</style>
</head>
<body>

<h2>SALES INVOICE</h2>
<h3>Invoice #{{ $sale->id }}</h3>

<b>Customer:</b> {{ $sale->customer->name ?? 'Walk-in' }} <br>
<b>Date:</b> {{ $sale->sale_date }} <br><br>

<table>
<thead>
<tr>
<th>#</th>
<th>Product</th>
<th>Qty</th>
<th>Unit Price (Rs.)</th>
<th>Total (Rs.)</th>
</tr>
</thead>

<tbody>
@foreach($sale->saleItems as $item)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $item->product->name }}</td>
<td>{{ $item->quantity }}</td>
<td>{{ number_format($item->selling_price, 2) }}</td>
<td>{{ number_format($item->total, 2) }}</td>
</tr>
@endforeach
</tbody>
</table>

<br><br>

<b>Subtotal:</b> Rs. {{ number_format($sale->total_amount,2) }} <br>
<b>Discount:</b> Rs. {{ number_format($sale->discount,2) }} <br>
<b>Tax:</b> Rs. {{ number_format($sale->tax,2) }} <br>
<b>Final Total:</b> <span style="font-size: 17px;font-weight:bold;">
Rs. {{ number_format(($sale->total_amount - $sale->discount) + $sale->tax,2) }}
</span>

<br><br>
<h3>Thank you for your purchase!</h3>
</body>
</html>
