<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 6px;
      text-align: left;
      word-wrap: break-word;
    }

    th {
      background-color: #f2f2f2;
    }

    .image-cell {
      width: 100px;
    }

    img {
      max-width: 100%;
      height: auto;
    }
  </style>
</head>

<body>
  <h2 style="text-align: center;">Orders Report</h2>
  <table>
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Product Name</th>
        <th class="image-cell">Product Image</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Order Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
        @foreach ($order->orderItems as $item)
          <tr>
            <td>{{ $order->user->username }}</td>
            <td>{{ $item->product->name }}</td>
            <td>
              <img
                src="/Users/sohel/Desktop/University/September/Web Engineering/GreenwichLandsMarket/public/{{ $item->product->mainimage }}"
                alt="{{ $item->product->name }}">
            </td>
            <td>{{ $item->quantity }}</td>
            <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
            <td>{{ $order->updated_at->format('d-M-Y') }}</td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</body>

</html>
