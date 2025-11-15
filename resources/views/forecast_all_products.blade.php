<!DOCTYPE html>
<html>
<head>
    <title>Product Forecast</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #f3f3f3;
        }
    </style>
</head>
<body>

<h2 style="text-align:center">All Products Forecast</h2>

<table id="forecastTable">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Weekly Sales Forecast</th>
            <th>Weekly Revenue Forecast</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>
$(document).ready(function() {

    $.ajax({
        url: "/forecast-all-products",
        type: "GET",
        dataType: "json",
        success: function(data) {

            let tbody = $("#forecastTable tbody");
            tbody.empty();

            $.each(data, function(key, item) {
                let row = `
                    <tr>
                        <td>${item.product_id}</td>
                        <td>${item.product_name}</td>
                        <td>${item.sales_forecast.weekly_sales_forecast}</td>
                        <td>${item.revenue_forecast.weekly_revenue_forecast}</td>
                    </tr>
                `;
                tbody.append(row);
            });

        },
        error: function(xhr) {
            console.log("Error:", xhr.responseText);
        }
    });

});
</script>

</body>
</html>
