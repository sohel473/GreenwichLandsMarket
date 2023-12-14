<x-layout>
  <div class="container mt-4">
    <div class="row">

      <h1 class="text-center">Home</h1>

      <!-- Show and Sort By dropdowns -->
      <div class="col-12 d-flex justify-content-end">
        <div class="col-md-3 mb-3">
          <label for="show-dropdown" class="d-none d-md-inline">Show:</label>
          <select id="show-dropdown" class="form-control form-control-sm" onchange="changePerPage(this)">
            <option value="6" @if ($perPage == 6) selected @endif>6</option>
            <option value="9" @if ($perPage == 9) selected @endif>9</option>
            <option value="12" @if ($perPage == 12) selected @endif>12</option>
          </select>
        </div>

        <div class="col-md-3 mb-3">
          <label for="sort-dropdown" class="d-none d-md-inline">Sort By:</label>
          <select id="sort-dropdown" class="form-control form-control-sm" onchange="changeSort(this)">
            <option value="">Default</option>
            <option value="price-ASC" @if ($sort == 'price-ASC') selected @endif>Price (Low &gt; High)</option>
            <option value="price-DESC" @if ($sort == 'price-DESC') selected @endif>Price (High &gt; Low)</option>
          </select>
        </div>
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
          {{ $pictures->appends(['search' => request()->query('search')])->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>

  <script>
    function changePerPage(select) {
      const perPage = select.value;
      window.location.href = `{{ route('home') }}?search={{ request()->query('search') }}&perPage=${perPage}`;
    }

    function changeSort(select) {
      const sort = select.value;
      window.location.href =
        `{{ route('home') }}?search={{ request()->query('search') }}&perPage={{ $perPage }}&sort=${sort}`;
    }
  </script>
</x-layout>
