<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pictures Report</title>
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
  <h2 style="text-align: center;">Pictures Report</h2>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th class="image-cell">Image</th>
        <th>Price</th>
        <th>Old Price</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pictures as $picture)
        <tr>
          <td>{{ $picture->name }}</td>
          <td><img
              src="/Users/sohel/Desktop/University/September/Web Engineering/GreenwichLandsMarket/public/{{ $picture->mainimage }}"
              alt="{{ $picture->name }}"></td>

          <td>${{ number_format($picture->price, 2) }}</td>
          <td>${{ number_format($picture->old_price, 2) }}</td>
          <td>{{ $picture->created_at->format('d-M-Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
