@extends('layouts.auth')

@section('page_styles')

@endsection

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b> {{ config('app.name') }} </b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('post_login') }}" method="post">
                @csrf
                <div class="input-group">
                    <select name="country_code" id="country_code" class="select2 form-control">
                        @foreach (\App\Helpers\Helper::filterCountries(['+233'], ['code', 'd_code']) as $country)
                            <option value="{{ $country['d_code'] }}"> {{ $country['code'] }} ({{{ $country['d_code'] }}}) </option>
                        @endforeach
                    </select>
                    <input type="text" name="phone" class="phone form-control @error('phone') is-invalid @enderror"value="{{ old('phone') }}" placeholder="0244000000" />
                    <div class="input-group-text"><span class="bi bi-telephone"></span></div>
                </div>
                @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="input-group mt-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" />
                    <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="row mt-3 justify-content-end">
                    {{-- <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                            <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
                        </div>
                    </div> --}}

                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection


@section('page_script')
    <script>

        $(document).ready(function(){
            // Basic Select2 select
            $(".select2").each(function () {
            let $this = $(this),
            $placeholder = "{{ __('locale.labels.select_one') }}",
            $allowClear = false;
            if ($this.prop("multiple")) {
            $placeholder = "{{ __('locale.labels.select_one_or_more') }}";
            $allowClear = true;
            }

            $this.wrap('<div class="position-relative"></div>')
            $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent(),
            placeholder: $placeholder,
            allowClear: $allowClear
            });
            });
        })
    </script>
@endsection
