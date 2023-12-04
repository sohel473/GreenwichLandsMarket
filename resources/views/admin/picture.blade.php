<x-layout>
  @section('title', 'Picture Details')

  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-6 col-md-12 mb-4">
        {{-- Main Image --}}
        <div class="text-center">
          <img src="{{ $product->mainimage }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-height: 400px;">
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        {{-- Details --}}
        <h2>{{ $product->name }}</h2>
        <p class="text-muted">{{ $product->description }}</p>

        <div class="my-3">
          <h4 class="text-success">
            <strong>Price: ${{ number_format($product->price, 2) }}</strong>
          </h4>
          @if ($product->old_price > 0)
            <p class="text-muted">
              <del>Old Price: ${{ number_format($product->old_price, 2) }}</del>
            </p>
          @endif
        </div>

        {{-- Add to Cart Button --}}
        @cannot('admin-access')
          <form action="#" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
          </form>
        @endcannot
      </div>
    </div>
  </div>
</x-layout>
