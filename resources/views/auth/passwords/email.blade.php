
@extends('layouts.frontend.app')
@section('title','Email')
@push('css')
    <link href="{{asset('assets/frontend/css')}}/auth/styles.css" rel="stylesheet">
    <link href="{{asset('assets/frontend/css')}}/auth/responsive.css" rel="stylesheet">
@endpush
@section('content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>Login</b></h1>
    </div><!-- slider -->
    <section class="blog-area section">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-0"></div>
                <div class="col-lg-8 col-md-12">
                    <div class="post-wrapper">
                        <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- post-wrapper -->
                </div><!-- col-sm-8 col-sm-offset-2 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section -->
@endsection
