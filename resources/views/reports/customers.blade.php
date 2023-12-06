<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customers Report</title>
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

    .date-of-birth {
      min-width: 120px;
      /* Adjust as needed */
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <h2 style="text-align: center;">Customers Report</h2>
  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th class="date-of-birth">Date of Birth</th>
        <th>Telephone</th>
        <th>Address</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer)
        <tr>
          <td>{{ $customer->username ?? 'N/A' }}</td>
          <td>{{ $customer->email ?? 'N/A' }}</td>
          <td>{{ $customer->profile->first_name ?? 'N/A' }}</td>
          <td>{{ $customer->profile->last_name ?? 'N/A' }}</td>
          <td>
            {{ $customer->profile->date_of_birth ? date('d-M-Y', strtotime($customer->profile->date_of_birth)) : 'N/A' }}
          </td>
          <td>{{ $customer->profile->telephone ?? 'N/A' }}</td>
          <td>{{ $customer->profile->address ?? 'N/A' }}</td>
        </tr>
      @endforeach

    </tbody>
  </table>
</body>

</html>
