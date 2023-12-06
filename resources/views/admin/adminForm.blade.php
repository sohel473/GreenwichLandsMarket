<x-layout>

  @section('title', isset($admin) ? 'Edit Admin' : 'Create New Admin')

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-8 offset-md-2 mb-4">
        <h2>{{ isset($admin) ? 'Edit Admin' : 'Create New Admin' }}</h2>

        {{-- Form for creating or editing an admin --}}
        <form action="{{ isset($admin) ? route('admins.update', $admin) : route('admins.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @if (isset($admin))
            @method('PUT')
          @endif

          {{-- User Name --}}
          <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" class="form-control" id="username" name="username"
              value="{{ old('username', $admin->username ?? '') }}" required>
            @error('username')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email"
              value="{{ old('email', $admin->email ?? '') }}">
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password --}}
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"
              {{ !isset($admin) ? 'required' : '' }}>
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password Confirmation --}}
          <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
              {{ !isset($admin) ? 'required' : '' }}>
          </div>

          {{-- Submit Button --}}
          <button type="submit" class="btn btn-primary">{{ isset($admin) ? 'Update' : 'Create' }} Admin</button>
        </form>
      </div>
    </div>
  </div>

</x-layout>
