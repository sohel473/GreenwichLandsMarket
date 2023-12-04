<x-layout>
  <section class="section register min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">
          <!-- Login Card -->
          <div class="card w-100">
            <div class="card-body">
              <!-- Title -->
              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                <p class="text-center small">Enter your username & password to login</p>
              </div>

              <!-- Login Form -->
              <form class="row g-3" action="/login" method="POST">
                @csrf
                <!-- Username -->
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" id="yourUsername">
                  @error('username')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <!-- Password -->
                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword">
                  @error('password')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <!-- Submit Button -->
                <div class="col-12 mt-3">
                  <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
                <!-- Register Link -->
                <div class="col-12 mt-3 text-center">
                  <p class="small">Don't have an account? <a href="/register">Create an account</a></p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-layout>
