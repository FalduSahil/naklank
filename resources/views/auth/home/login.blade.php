@extends('home.layout.app')

@section('content')
    <section class="my-lg-14 my-8">
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                    <img src="{{ getPath('home') }}/images/svg-graphics/signin-g.svg" alt="" class="img-fluid"/>
                </div>
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1">
                    <div class="mb-lg-9 mb-5">
                        <h1 class="mb-1 h2 fw-bold">Sign in to {{ getConstant('SITE_NAME') }}</h1>
                        <p>Welcome back to {{ getConstant('SITE_NAME') }}! Enter your email to get started.</p>
                    </div>
                    @error('error')
                    <p class="alert alert-danger text-black pb-3 text-center font-weight-bold">{{ $message  }}</p>
                    @enderror
                    <form method="POST" action="{{ route('userLogin') }}" id="loginForm" >
                        <input type="hidden" name="redirectTo" value="{{ url()->previous() }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="formSigninEmail" class="form-label visually-hidden">Email address</label>
                                <input name="email" value="{{ old('email') }}" type="email" class="form-control" id="formSigninEmail" placeholder="Email"/>
                                @error('email')
                                <p style="color: indianred; font-size: 15px" class="mt-1">{{ $message  }}</p>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="password-field position-relative">
                                    <label for="formSigninPassword" class="form-label visually-hidden">Password</label>
                                    <div class="password-field position-relative">
                                        <input name="password" type="password" class="form-control fakePassword" id="formSigninPassword" placeholder="*****"/>
                                    </div>
                                    @error('password')
                                    <p style="color: indianred; font-size: 15px" class="mt-1">{{ $message  }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>Forgot password?
                                    <a href="{{ route('showForgotPassword') }}">Reset It</a>
                                </div>
                            </div>
                            <div class="col-12 d-grid">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ getPath('common') }}/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('common') }}/js/custom/custom.js"></script>
    <script>
        $(function () {
            validateRequest('loginForm', {
                email: {
                    email: true,
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 8,
                }
            }, {
                email: {
                    required: "Please enter a email",
                    email: "Please enter a valid email address",
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Please enter at least 8 characters",
                },
            });
        });
    </script>
@endpush