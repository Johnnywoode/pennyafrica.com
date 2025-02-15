{{-- For submenu --}}
<ul class="nav nav-treeview">
    @if(isset($menu))
        @foreach($menu as $submenu)
            @php
                $submenuTranslation = isset($menu->i18n) ? $menu->i18n : "";
            @endphp

            {{-- @can($submenu->access, auth()->user()) --}}
                <li class="nav-item ps-3">
                    <a href="{{isset($submenu->url) ? url($submenu->url):'javascript:void(0)'}}" target="{{ isset($submenu->target)? $submenu->target : '' }}" class="nav-link {{ isset($submenu->slug) && str_contains(request()->path(),$submenu->slug) ? 'active' : '' }}">
                        @if(isset($submenu->icon))
                            <i class="{{ $submenu->icon ?? "" }}"></i>
                        @endif
                        <p data-i18n="{{ $submenuTranslation }}">{{ $submenu->name }}</p>
                    </a>
                    {{-- @if (isset($submenu->tooltip))
                        <span role="button" title="Click to show" class="tippy me-2" data-tippy-id="{{ $submenu->tooltip }}" data-tippy-inline="true"><i class="fa fa-question-circle"></i></span>
                    @endif --}}
                    @if (isset($submenu->submenu))
                        @include('panels/submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            {{-- @endcan --}}
        @endforeach
    @endif
</ul>
