<!DOCTYPE html>
<html>
<head>
    <title>Product Forecast</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 30px;
        }

        /* Header + Dashboard Button */
        .header {
            width: 85%;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h2 {
            color: #333;
            letter-spacing: 1px;
        }

        .btn-dashboard {
            background: #4a90e2;
            padding: 10px 18px;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-dashboard:hover {
            background: #3a7ac7;
        }

        /* Card Container */
        .container {
            width: 85%;
            margin: 25px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #e6e6e6;
        }

        th {
            background: #304ffe;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        tr:hover {
            background: #f4f7ff;
        }

        td {
            font-size: 15px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>All Products Forecast</h2>
    <a href="/dashboard" class="btn-dashboard">← Return to Dashboard</a>
</div>

<div class="container">
    <table id="forecastTable">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Weekly Sales Forecast</th>
                <th>Weekly Revenue Forecast</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

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