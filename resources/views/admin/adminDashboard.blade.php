<x-layout>
  <div class="container py-md-5 container--narrow">
    <div class="text-center">
      <h2>
        {{ auth()->user()->username }}
        <a href="/profile" class="btn btn-info btn-sm">See Profile</a>
      </h2>
    </div>

    <!-- Nav Pills -->
    <div class="d-flex justify-content-center">
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        {{-- Picture --}}
        <li class="nav-item">
          <a class="nav-link {{ $activeTab == 'pictures' ? 'active' : '' }}" id="pills-contact-tab" data-toggle="pill"
            href="#pills-contact" role="tab" aria-controls="pills-contact"
            aria-selected="{{ $activeTab == 'pictures' ? 'true' : 'false' }}">
            Pictures: {{ $pictures->count() }}
          </a>
        </li>
        {{-- Customer --}}
        <li class="nav-item">
          <a class="nav-link {{ $activeTab == 'customers' ? 'active' : '' }}" id="pills-home-tab" data-toggle="pill"
            href="#pills-home" role="tab" aria-controls="pills-home"
            aria-selected="{{ $activeTab == 'customers' ? 'true' : 'false' }}">
            Customers: {{ $customers->count() }}
          </a>
        </li>
        {{-- Admin --}}
        <li class="nav-item">
          <a class="nav-link {{ $activeTab == 'admins' ? 'active' : '' }}" id="pills-profile-tab" data-toggle="pill"
            href="#pills-profile" role="tab" aria-controls="pills-profile"
            aria-selected="{{ $activeTab == 'admins' ? 'true' : 'false' }}">
            Admins: {{ $admins->count() }}
          </a>
        </li>
      </ul>
    </div>


    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">

      <!-- Pictures Tab -->
      <div class="tab-pane fade {{ $activeTab == 'pictures' ? 'show active' : '' }}" id="pills-contact" role="tabpanel"
        aria-labelledby="pills-contact-tab">
        <!-- Add Picture Button -->
        <div class="text-center">
          <a href="/create-picture" class="btn btn-sm btn-outline-primary mb-2">Add Picture</a>
          <a href="#" class="btn btn-sm btn-outline-success mb-2">Download
            Pictures
            Report</a>
          <div class="text-center">
            <form action="/admin" method="GET">
              <input type="text" name="picture_search" class="form-control d-inline-block mb-2" style="width: 50%;"
                placeholder="Search Pictures by name, description">
              <button type="submit" class="btn btn-sm btn-primary">Search</button>
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="list-group">
              @foreach ($pictures as $picture)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  <div style="flex: 1; min-width: 0;">
                    <strong style="color: blue; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                      {{ $picture->name }}
                    </strong> created at
                    {{ $picture->created_at->format('n/j/Y') }}
                  </div>
                  <div class="icon-container" style="flex-shrink: 0;">
                    {{-- View --}}
                    <a href="/picture/{{ $picture->id }}" class="text-info me-2" data-toggle="tooltip"
                      data-placement="top" title="View">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    {{-- Edit --}}
                    <a href="/picture/{{ $picture->id }}/edit" class="text-primary me-2" data-toggle="tooltip"
                      data-placement="top" title="Edit">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    {{-- Delete --}}
                    <a href="javascript:void(0);" onclick="confirmPictureDelete('/picture/{{ $picture->id }}')"
                      class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                    <!-- Hidden Delete Form -->
                    <form id="picture-delete-form" action="/picture/{{ $picture->id }}" method="POST"
                      style="display: none;">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </div>
              @endforeach
              <!-- Pagination Links -->
              <div class="row">
                <div class="col-12">
                  {{ $pictures->links('vendor.pagination.bootstrap-4') }}
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <!-- Customers Tab -->
      <div class="tab-pane fade {{ $activeTab == 'customers' ? 'show active' : '' }}" id="pills-home" role="tabpanel"
        aria-labelledby="pills-home-tab">
        <!-- Add Customer Button -->
        <div class="text-center">
          <a href="{{ route('customers.create') }}" class="btn btn-sm btn-outline-primary mb-2">Add Customer</a>
          <a href="#" class="btn btn-sm btn-outline-success mb-2">Download
            Customers
            Report</a>
        </div>
        <div class="text-center">
          <form action="/admin" method="GET">
            <input type="text" name="customer_search" class="form-control d-inline-block mb-2" style="width: 50%;"
              placeholder="Search Customers by username, telephone">
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
          </form>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="list-group">
              @foreach ($customers as $customer)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  <div>
                    <strong style="color: blue;">{{ $customer->username }}</strong> created at
                    {{ $customer->created_at->format('n/j/Y') }}
                  </div>
                  <div>
                    {{-- View --}}
                    <a href="/profile/{{ $customer->id }}" class="text-info me-2" data-toggle="tooltip"
                      data-placement="top" title="View">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    {{-- Edit --}}
                    <a href="{{ route('customers.edit', ['user' => $customer->id]) }}" class="text-primary me-2"
                      data-toggle="tooltip" data-placement="top" title="Edit">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    {{-- Delete --}}
                    <a href="javascript:void(0);" onclick="confirmClientDelete('/customer/{{ $customer->id }}')"
                      class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                    <!-- Hidden Delete Form for Clients -->
                    <form id="customer-delete-form" action="" method="POST" style="display: none;">
                      @csrf
                      @method('DELETE')
                    </form>

                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <!-- Admins Tab -->
      <div class="tab-pane fade {{ $activeTab == 'admins' ? 'show active' : '' }}" id="pills-profile"
        role="tabpanel" aria-labelledby="pills-profile-tab">
        <!-- Add Admin Button -->
        <div class="text-center">
          <a href="/create_admin_user" class="btn btn-sm btn-outline-primary mb-2">Add Admin</a>
          <a href="#" class="btn btn-sm btn-outline-success mb-2">Download
            Admins
            Report</a>
        </div>
        <div class="text-center">
          <form action="/admin" method="GET">
            <input type="text" name="admin_search" class="form-control d-inline-block mb-2" style="width: 50%;"
              placeholder="Search Admin by username">
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
          </form>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="list-group">
              @foreach ($admins as $admin)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                  <div>
                    <strong style="color: blue;">{{ $admin->username }}</strong> created at
                    {{ $admin->created_at->format('n/j/Y') }}
                  </div>
                  <div>
                    <a href="/admin_user/{{ $admin->id }}" class="text-info me-2" data-toggle="tooltip"
                      data-placement="top" title="View">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="/admin_user/{{ $admin->id }}/edit" class="text-primary me-2" data-toggle="tooltip"
                      data-placement="top" title="Edit">
                      <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    @if (auth()->user()->id !== $admin->id)
                      <a href="javascript:void(0);" onclick="confirmAdminDelete('/admin_user/{{ $admin->id }}')"
                        class="text-danger" data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    @endif
                    <!-- Hidden Delete Form for Admin Users -->
                    <form id="admin-delete-form" action="" method="POST" style="display: none;">
                      @csrf
                      @method('DELETE')
                    </form>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    // Picture Delete Confirmation
    function confirmPictureDelete(deleteUrl) {
      if (confirm("Are you sure you want to delete this picture?")) {
        var form = document.getElementById('picture-delete-form');
        form.action = deleteUrl;
        form.submit();
      }
    }

    // Customer Delete Confirmation
    function confirmClientDelete(deleteUrl) {
      if (confirm("Are you sure you want to delete this picture?")) {
        var form = document.getElementById('customer-delete-form');
        form.action = deleteUrl;
        form.submit();
      }
    }

    // Admin User Delete Confirmation
    function confirmAdminDelete(deleteUrl) {
      if (confirm("Are you sure you want to delete this admin user?")) {
        var form = document.getElementById('admin-delete-form');
        form.action = deleteUrl;
        form.submit();
      }
    }
  </script>

</x-layout>
