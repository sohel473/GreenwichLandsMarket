{{-- Cart Total Component --}}
@auth
  @php
    $cartTotal = \App\Models\Cart::where('user_id', auth()->id())
        ->where('purchased', false)
        ->count();
  @endphp
  <span class="badge badge-light">{{ $cartTotal }}</span>
@else
  <span class="badge badge-light">0</span>
@endauth
