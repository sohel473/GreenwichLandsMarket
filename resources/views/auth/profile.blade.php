<x-layout>

  <div class="container mb-4">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <h2>User Profile</h2>

        {{-- Profile Form --}}
        <form action="{{ route('profile.update', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- Profile Photograph --}}
          <div class="form-group">
            <label for="photograph">Profile Photograph</label>
            <input type="file" class="form-control-file" id="photograph" name="photograph">
          </div>

          {{-- First Name --}}
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name"
              value="{{ old('first_name') ?? $user->profile->first_name }}" required>
          </div>

          {{-- Last Name --}}
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"
              value="{{ old('last_name') ?? $user->profile->last_name }}" required>
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
              disabled>
          </div>

          {{-- Telephone --}}
          <div class="form-group">
            <label for="telephone">Telephone</label>
            <input type="tel" class="form-control" id="telephone" name="telephone"
              value="{{ old('telephone') ?? $user->profile->telephone }}">
          </div>

          {{-- Password Field --}}
          <div class="form-group">
            <label for="password">New Password (leave blank if you do not want to change it)</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Password Confirmation Field --}}
          <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
              autocomplete="new-password">
            @error('password_confirmation')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>

          {{-- Address --}}
          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') ?? $user->profile->address }}</textarea>
          </div>

          {{-- Date of Birth --}}
          <div class="form-group">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date"
              value="{{ old('date_of_birth') ?? optional($user->profile)->date_of_birth?->format('Y-m-d') }}"
              name="date_of_birth" class="form-control" id="date_of_birth" required>
            @error('date_of_birth')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>


          {{-- Update Button --}}
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
      </div>
    </div>
  </div>
</x-layout>
