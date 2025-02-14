<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img src="../../dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light text-uppercase">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
            </span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                @php
                    $menuData = App\Helpers\Helper::menuData(true);
                    $sidebarMenu = Auth::user()->isAdmin() ? $menuData->admin : $menuData->user;
                @endphp

                @foreach($sidebarMenu as $menu)
                @if(isset($menu->navheader))
                <li class="navigation-header">
                    <span>{{ $menu->navheader }}</span>
                    <i data-feather="more-horizontal"></i>
                </li>
                @else
                {{-- Add Custom Class with nav-item --}}
                @php
                $custom_classes = isset($menu->classlist) ? $menu->classlist : "";
                $translation = isset($menu->i18n) ? $menu->i18n : "";
                $menu->url = $menu->url == null || $menu->url == '' ? '#' : $menu->url;

                $menuOpenClass = '';
                if (isset($menu->submenu)) {
                    foreach ($menu->submenu as $submenu) {
                        if (str_contains(request()->path(), $submenu->slug)) {
                        $menuOpenClass = 'menu-open';
                        break;
                        }
                    }
                }
                @endphp

                <li
                    class="nav-item {{ $menuOpenClass }} {{ $custom_classes }}">
                    <a href="{{ $menu->url }}" class="nav-link {{ isset($menu->slug) && str_contains(request()->path(),$menu->slug) ? 'active' : '' }}" target="{{ isset($menu->target)? $menu->target : '' }}">
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <p data-i18n="{{ $translation }}">{{ $menu->name }} @if (isset($menu->submenu)) <i
                                class="nav-arrow bi bi-chevron-right"></i> @endif</p>
                    </a>

                    @if(isset($menu->submenu))
                        @include('panels/submenu', ['menu' => $menu->submenu])
                    @endif
                </li>
                {{-- @endcanany --}}
                @endif
                @endforeach
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
