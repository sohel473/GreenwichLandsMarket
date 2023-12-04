<x-layout>
  <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
          <!-- Registration Card -->
          <div class="card mb-3">
            <div class="card-body">
              <!-- Title -->
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                <p class="text-center small">Enter your personal details to create account</p>
              </div>

              <!-- Registration Form -->
              <form class="row g-3" method="POST" action="/register">
                @csrf
                <!-- Username -->
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Username</label>
                  <input type="text" value="{{ old('username') }}" name="username" class="form-control"
                    id="yourUsername" required>
                  @error('username')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <!-- Email -->
                <div class="col-12">
                  <label for="yourEmail" class="form-label">Email</label>
                  <input type="email" value="{{ old('email') }}" name="email" class="form-control" id="yourEmail">
                  @error('email')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <!-- Password -->
                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword" required>
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <!-- Confirm Password -->
                <div class="col-12">
                  <label for="confirmPassword" class="form-label">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" id="confirmPassword"
                    required>
                </div>
                <!-- Submit Button -->
                <div class="col-12 mt-3">
                  <button class="btn btn-primary w-100" type="submit">Create Account</button>
                </div>
                <!-- Login Link -->
                <div class="col-12 text-center mt-3">
                  <p class="small mb-0">Already have an account? <a href="login">Log in</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layout>
