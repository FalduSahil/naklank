@extends('admin.layout.login.app')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img class="img-fluid" height="120" width="120" src="{{ getPath('web') }}/img/logo.png" alt="{{ getConstant('SITE_NAME') }}">
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <form id="loginForm" name="loginForm" method="post" action="{{ route('adminLogin') }}">
                    @csrf
                    @error('error')
                    <p style="color: indianred; font-size: 18px" class="login-box-msg">{{ $message  }}</p>
                    @enderror
                    <div class="form-group mb-3 mt-1">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                        @error('email')
                        <p style="color: indianred; font-size: 15px" class="mt-1">{{ $message  }}</p>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        @error('password')
                        <p style="color: indianred; font-size: 15px" class="mt-1">{{ $message  }}</p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
