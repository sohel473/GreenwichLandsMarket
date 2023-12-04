<x-layout>
  <div class="container my-5">
    @if ($cartExists)
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
          <tr>
            <th scope="row">1</th>
            <td>
              <img src="{{ asset('storage/landmarks/Pic 1_1701672308.jpg') }}" alt="Product Image"
                style="height: 100px; width: auto; margin-right: 10px;">
              Static Product Name
            </td>
            <td>
              <button class="btn btn-secondary btn-sm mr-2">-</button>
              1
              <button class="btn btn-secondary btn-sm ml-2">+</button>
            </td>
            <td class="text-right">$10.00</td>
            <td><button class="btn btn-danger btn-sm">Remove</button></td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>
              <img src="{{ asset('storage/landmarks/Pic 1_1701672308.jpg') }}" alt="Product Image"
                style="height: 100px; width: auto; margin-right: 10px;">
              Another Static Product
            </td>
            <td>
              <button class="btn btn-secondary btn-sm mr-2">-</button>
              2
              <button class="btn btn-secondary btn-sm ml-2">+</button>
            </td>
            <td class="text-right">$20.00</td>
            <td><button class="btn btn-danger btn-sm">Remove</button></td>
          </tr>
          <tr>
            <th scope="row"></th>
            <td colspan="2">Total</td>
            <td class="text-right">$30.00</td>
            <td></td>
          </tr>
          <tr>
            <th scope="row"></th>
            <td colspan="4" class="text-right">
              <a href="#" class="btn btn-warning mr-4">Continue Shopping</a>
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
