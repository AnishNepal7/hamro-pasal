<!DOCTYPE html>
<html>
<head>
    <title>Stock Movement Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #333; text-align: left; }
        th { background: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Stock Movement Report</h2>

<p><strong>Generated:</strong> {{ now()->format('d M, Y H:i A') }}</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @foreach($movements as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $m->product->name }}</td>
            <td>{{ $m->type }}</td>
            <td>{{ $m->quantity }}</td>
            <td>{{ $m->description }}</td>
            <td>{{ $m->created_at->format('d M, Y H:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
