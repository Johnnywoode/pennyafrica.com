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

        <div class="col-lg-4 col-6">
            <a href="{{ route(config('app.admin_path') . '.users') }}">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3><sup class="fs-5">{{ $stats['active_users'] }}</sup> / {{ $stats['total_users'] }}</h3>
                        <p class="fs-4 fw-bold mb-0">{{ __('locale.labels.users') }}</p>
                    </div>
                    <i class="bi bi-people small-box-icon"></i>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-6">
            <a href="{{ route(config('app.admin_path') . '.transactions') }}">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>
                            <sup class="fs-5 badge bg-white text-success" title="{{ __('locale.labels.credit_transactions') }}">{{ $stats['credit_transactions'] }}</sup> /
                            <sup class="fs-5 badge bg-white text-danger" title="{{ __('locale.labels.debit_transactions') }}">{{ $stats['debit_transactions'] }}</sup> / {{ $stats['total_transactions'] }}
                        </h3>
                        <p class="fs-4 fw-bold mb-0"> {{ __('locale.labels.transactions') }} </p>
                    </div>
                    <i class="bi bi-currency-exchange small-box-icon"></i>
                </div>
            </a>
        </div>

    </div>
@endsection
