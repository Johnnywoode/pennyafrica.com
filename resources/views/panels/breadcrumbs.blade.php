{{-- <ol class="breadcrumb float-sm-end">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
</ol> --}}

@if(@isset($breadcrumbs))
<ol class="breadcrumb float-sm-end">
    @foreach ($breadcrumbs as $breadcrumb)
    <li class="breadcrumb-item @if(!isset($breadcrumb['link'])) active @endif">
        @if(isset($breadcrumb['link']))
            <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link']:url($breadcrumb['link']) }}">
                {!! $breadcrumb['name'] !!}
            </a>
        @else
            {!! $breadcrumb['name'] !!}
        @endif
    </li>
    @endforeach
</ol>
@endisset
