<x-layout>

  @section('title', 'Create New Picture')

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <h2>Create New Picture</h2>

        {{-- Form for creating a new product --}}
        <form action="/picture" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- Picture Name --}}
          <div class="form-group">
            <label for="name">Picture Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Description --}}
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
            @error('description')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Main Image --}}
          <div class="form-group">
            <label for="mainimage">Main Image</label>
            <input type="file" class="form-control-file" id="mainimage" name="mainimage" required>
            @error('mainimage')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Price --}}
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}"
              step="0.01" required>
            @error('price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Old Price --}}
          <div class="form-group">
            <label for="old_price">Old Price</label>
            <input type="number" class="form-control" id="old_price" name="old_price" value="{{ old('old_price') }}"
              step="0.01">
            @error('old_price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Submit Button --}}
          <button type="submit" class="btn btn-primary">Create Picture</button>
        </form>
      </div>
    </div>
  </div>

</x-layout>
