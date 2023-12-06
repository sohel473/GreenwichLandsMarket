<x-layout>
  <div class="container my-5">
    @if ($isExists)
      <div class="my-5">
        <h2>Your Cart</h2>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col" width="15%">#</th>
            <th scope="col">Product</th>
            <th scope="col">Quantity</th>
            <th scope="col" class="text-right">Price</th>
            <th scope="col">Remove</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($carts as $index => $cart)
            <tr>
              <th scope="row">{{ $index + 1 }}</th>

              <td>
                <img src="{{ $cart->product->mainimage }}" alt="Product Image"
                  style="height: 100px; width: auto; margin-right: 10px;">
                {{ $cart->product->name }}
              </td>
              <td>
                <form
                  action="{{ route('cart.changeQuantity', ['productId' => $cart->product->id, 'changeType' => 'decrease']) }}"
                  method="POST">
                  @csrf
                  <button type="submit" class="btn btn-secondary btn-sm">-</button>
                </form>
                {{ $cart->quantity }}
                <form
                  action="{{ route('cart.changeQuantity', ['productId' => $cart->product->id, 'changeType' => 'increase']) }}"
                  method="POST">
                  @csrf
                  <button type="submit" class="btn btn-secondary btn-sm">+</button>
                </form>
              </td>
              <td class="text-right">${{ number_format($cart->total, 2) }}</td>
              <td>
                <form action="{{ route('cart.remove', $cart->product->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
              </td>
            </tr>
          @endforeach
          <tr>
            <th scope="row"></th>
            <td colspan="2">Total</td>
            <td class="text-right">${{ number_format($order->total, 2) }}</td>
            <td></td>
          </tr>
          <tr>
            <th scope="row"></th>
            <td colspan="4" class="text-right">
              <a href="{{ route('home') }}" class="btn btn-warning mr-4">Continue Shopping</a>
              <a href="#" class="btn btn-success mr-4">Proceed To Checkout</a>
            </td>
          </tr>
        </tbody>
      </table>
    @else
      <center>
        <img src="{{ asset('icon_empty_cart.png') }}" alt="Empty Cart">
        <h1>Your Cart is Empty!</h1>
        <p>Looks like you haven't made an order yet.</p>
        <a href="{{ route('home') }}" class="btn btn-warning">Continue Shopping</a>
      </center>
    @endif
  </div>
</x-layout>
