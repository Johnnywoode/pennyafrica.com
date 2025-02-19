@php
  use Carbon\Carbon;
@endphp

<nav class="app-header navbar navbar-expand bg-body" data-bs-theme="light">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
      {{-- <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li> --}}
    </ul>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
      <!--begin::Navbar Search-->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="bi bi-search"></i>
        </a>
      </li> --}}
      <!--end::Navbar Search-->
      <li class="nav-item me-2 rounded border border-success">
        <label class="nav-link fw-bold" title="Penny Balance"> {{ Auth::user()->account->pennies }} </label>
      </li>
      <!--begin::Notifications Dropdown Menu-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
          <i class="bi bi-bell-fill"></i>
          <span
            class="navbar-badge badge text-bg-warning">{{ \App\Models\Notification::forUser(Auth::user()->id)->unread()->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span
            class="dropdown-item dropdown-header">{{ \App\Models\Notification::forUser(Auth::user()->id)->unread()->count() }}
            Notifications</span>
          <div class="dropdown-divider"></div>
          @foreach (\App\Models\Notification::forUser(Auth::user()->id)->unread()->get() as $item)
            <a href="#" class="dropdown-item">
              <i class="bi bi-save-fill me-2"></i> {{ $item->message }}
              <span class="float-end text-secondary fs-7">{{ Carbon::parse($item->created_at)->diffForHumans() }}</span>
            </a>
            <div class="dropdown-divider"></div>
          @endforeach
          <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
        </div>
      </li>
      <!--end::Notifications Dropdown Menu-->

      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle"></i>
          <span class="d-none d-md-inline">{{ explode(' ', Auth::user()->details->name)[0] }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="text-center p-1">
            <i class="bi bi-person-circle fs-3 d-block"></i>

            <div class="d-flex flex-column">
              <b class="fs-4 fw-bold">{{ Auth::user()->details->name }}</b>
              <small class=""> {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }} </small>
            </div>

          </li>
          <!--end::User Image-->
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-sm btn-outline-info"> <i class="bi bi-person-badge"></i> Profile</a>
            <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger float-end"> <i class="bi bi-power"></i>
              Sign out</a>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->

      <!--begin::Fullscreen Toggle-->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>
      <!--end::Fullscreen Toggle-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
