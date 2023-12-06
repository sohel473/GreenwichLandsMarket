<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Report</title>
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
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <h2 style="text-align: center;">Admin Report</h2>
  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($admins as $admin)
        <tr>
          <td>{{ $admin->username }}</td>
          <td>{{ $admin->email }}</td>
          <td>{{ $admin->created_at ? date('d-M-Y', strtotime($admin->created_at)) : 'N/A' }}
        </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>
