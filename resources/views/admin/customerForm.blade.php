<x-layout>

  @section('title', isset($customer) ? 'Edit Customer' : 'Create New Customer')

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8 offset-md-2 mb-4">
        <h2>{{ isset($customer) ? 'Edit Customer' : 'Create New Customer' }}</h2>

        {{-- Form for creating or editing a customer --}}
        <form action="{{ isset($customer) ? route('customers.update', $customer) : route('customers.store') }}"
          method="POST" enctype="multipart/form-data">
          @csrf
          @if (isset($customer))
            @method('PUT')
          @endif

          {{-- User Name --}}
          <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" class="form-control" id="username" name="username"
              value="{{ old('username', $customer->username ?? '') }}" required>
            @error('username')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
              value="{{ old('email', $customer->email ?? '') }}">
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password --}}
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password Confirmation --}}
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
              required>
          </div>

          {{-- Submit Button --}}
          <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Update' : 'Create' }} Customer</button>
        </form>
      </div>
    </div>
  </div>

</x-layout>
