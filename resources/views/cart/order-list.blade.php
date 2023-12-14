<x-layout>
  <div class="container my-5">
    <div class="text-center">
      <h1>Order List</h1>
    </div>
    <table class="table table-hover mt-4">
      <thead>
        <tr>
          <th scope="col"># Order ID</th>
          <th scope="col">Date</th>
          <th scope="col">Total Amount</th>
          <th scope="col">Products</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->updated_at->format('d M Y') }}</td>
            <td>${{ number_format($order->getTotalAttribute(), 2) }}</td>
            <td>
              @foreach ($order->orderItems as $item)
                <div>
                  <a href="{{ route('pictures.show', ['product' => $item->product->id]) }}">
                    {{ $item->product->name }}
                  </a>
                  (x{{ $item->quantity }})
                </div>
              @endforeach
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4">No orders found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</x-layout>
