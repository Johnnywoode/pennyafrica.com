@extends('layouts.app', ['page_title' => $page_title])

@section('content')
    {{-- {!! QrCode::size(300)->style('round')->generate('Embed this content into the QR Code') !!} --}}
    <div class="row">
        {{-- <div class="col-lg-4 col-6">
            <a href="{{ route('admin.attendees.index') }}">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $stats['total_attendees'] }}</h3>
                        <p>Registered Attendees</p>
                    </div>
                    <i class="bi bi-basket small-box-icon"></i>
                </div>
            </a>
        </div> --}}

        {{-- <div class="col-lg-4 col-6">
            <a href="{{ route('admin.checkins.index') }}">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3><sup class="fs-5">{{ $stats['checkin_today'] }}</sup> / {{ $stats['total_checkin'] }}</h3>
                        <p>In Attendance</p>
                    </div>
                    <i class="bi bi-check-circle-fill small-box-icon"></i>
                </div>
            </a>
        </div> --}}

        <div class="col-lg-4 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3><sup class="fs-5">{{ $stats['active_users'] }}</sup> / {{ $stats['total_users'] }}</h3>
                    <p>Users</p>
                </div>
                <i class="bi bi-people small-box-icon"></i>
            </div>
        </div>
    </div>
@endsection
