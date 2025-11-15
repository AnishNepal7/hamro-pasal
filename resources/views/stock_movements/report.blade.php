<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Movement Report</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Stock Movement Report ({{ $from }} - {{ $to }})</h2>

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
                    <td>{{ $m->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!--total quantity movements -->
    <h3 style="text-align: right; margin-top: 20px;">
        Total IN: {{ $movements->where('type', 'IN')->sum('quantity') }} <br>
        Total OUT: {{ $movements->where('type', 'OUT')->sum('quantity') }}
    </h3>
    



</body>
</html>
