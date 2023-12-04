<x-layout>
  <div class="container mt-4">
    <div class="row">
      <div class="col-12">
        <h1>Home</h1>
      </div>

      {{-- Displaying pictures in cards --}}
      <div class="row">
        @foreach ($pictures as $picture)
          <div class="col-md-4 mb-3">
            <div class="card">
              <a href="{{ route('pictures.show', $picture->id) }}" class="card-link">
                <img src="{{ $picture->mainimage }}" class="card-img-top" alt="{{ $picture->name }}"
                  style="height: 300px; object-fit: cover;">
              </a>
              <div class="card-body">
                <h5 class="card-title">{{ $picture->name }}</h5>
                <p class="card-text">${{ number_format($picture->price, 2) }}</p>
                @if ($picture->old_price > 0)
                  <p class="card-text"><del>${{ number_format($picture->old_price, 2) }}</del></p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination Links -->
      <div class="row">
        <div class="col-12">
          {{ $pictures->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</x-layout>
