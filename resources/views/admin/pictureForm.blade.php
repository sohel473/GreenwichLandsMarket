<x-layout>

  @section('title', isset($product) ? 'Edit Picture' : 'Create New Picture')

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8 offset-md-2 mb-4">
        <h2>{{ isset($product) ? 'Edit Picture' : 'Create New Picture' }}</h2>

        {{-- Form for creating or editing a product --}}
        <form action="{{ isset($product) ? route('pictures.update', $product) : route('pictures.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @if (isset($product))
            @method('PUT')
          @endif

          {{-- Picture Name --}}
          <div class="form-group">
            <label for="name">Picture Name</label>
            <input type="text" class="form-control" id="name" name="name"
              value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Description --}}
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          <!-- Main Image Input and Display -->
          <div class="row {{ isset($product) && $product->mainimage ? 'mt-3' : 'col-12' }}">
            <!-- File Input Column -->
            <div class="{{ isset($product) && $product->mainimage ? 'col-md-6 mt-6' : 'col-12' }}">
              <label for="mainimage" class="form-label">Main Image</label>
              <input type="file" name="mainimage" class="form-control-file" id="mainimage"
                {{ !isset($product) ? 'required' : '' }}>
              @error('mainimage')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <!-- Image Display Column -->
            @if (isset($product) && $product->mainimage)
              <div class="col-md-6 text-center">
                <img src="{{ $product->mainimage }}" alt="Main Image" style="max-width: 400px; max-height: 400px;">
              </div>
            @endif
          </div>


          {{-- Price --}}
          <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price"
              value="{{ old('price', $product->price ?? '') }}" step="0.01" required>
            @error('price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Old Price --}}
          <div class="form-group">
            <label for="old_price">Old Price</label>
            <input type="number" class="form-control" id="old_price" name="old_price"
              value="{{ old('old_price', $product->old_price ?? '') }}" step="0.01">
            @error('old_price')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Submit Button --}}
          <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }} Picture</button>
        </form>
      </div>
    </div>
  </div>

</x-layout>
