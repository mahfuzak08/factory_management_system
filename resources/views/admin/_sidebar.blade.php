<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold name-row mb-2">{{ Auth::user()->name }}</span>
          <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <span class="menu-title">{{ __('admin.dashboard') }}</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('sales') }}">
        <span class="menu-title">{{ __('admin.sales') }}</span>
        <i class="mdi mdi-cart-off menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('customer') }}">
        <span class="menu-title">{{ __('admin.customer') }}</span>
        <i class="mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('purchase') }}">
        <span class="menu-title">{{ __('admin.purchase') }}</span>
        <i class="mdi mdi-cart-plus menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('vendor') }}">
        <span class="menu-title">{{ __('admin.vendor') }}</span>
        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('employee') }}">
        <span class="menu-title">{{ __('admin.employee') }}</span>
        <i class="mdi mdi-account-check menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('expense') }}">
        <span class="menu-title">{{ __('admin.expense') }}</span>
        <i class="mdi mdi-cards-outline menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('bank_account') }}">
        <span class="menu-title">{{ __('admin.accounts') }}</span>
        <i class="mdi mdi-bank menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">{{__('admin.settings')}}</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{route('language')}}">{{__('admin.language')}}</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{route('user-manage')}}">{{__('admin.user_management')}}</a></li>
          <li class="nav-item"> <a class="nav-link" href="3">{{__('admin.role_management')}}</a></li>
          <li class="nav-item"> <a class="nav-link" href="pttons.html">{{__('admin.activity')}}</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf
        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
            {{ __('admin.logout') }}
        </x-responsive-nav-link>
      </form>
    </li>
  </ul>
</nav>