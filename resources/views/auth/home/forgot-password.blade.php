@extends('home.layout.app')

@section('content')
    <section class="my-lg-14 my-8">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-4 order-lg-1 order-2">
                    <img src="{{ getPath('home') }}/images/svg-graphics/fp-g.svg" alt="" class="img-fluid"/>
                </div>
                <div class="col-12 col-md-6 offset-lg-1 col-lg-4 order-lg-2 order-1 d-flex align-items-center">
                    <div>
                        <div class="mb-lg-9 mb-5">
                            <h1 class="mb-2 h2 fw-bold">Forgot your password?</h1>
                            <p>Please enter the email address associated with your account and We will send you a
                                temporary password.</p>
                        </div>
                        <form id="forgotPassword" method="POST">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="email" class="form-label visually-hidden">Email Address</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email"/>
                                    @error('email')
                                    <p style="color: indianred; font-size: 15px" class="mt-1">{{ $message  }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 d-grid gap-2">
                                    <button type="submit" class="btn btn-primary forgot-password">Reset Password
                                    </button>
                                    <a href="{{ url()->previous() ?? route('home') }}" class="btn btn-light">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ getPath('common') }}/js/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="{{ getPath('common') }}/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('common') }}/js/custom/custom.js"></script>
    <script>
        $(function () {
            ajaxSetup();
            validateRequest('forgotPassword', {
                email: {
                    email: true,
                    required: true,
                    remote: {url: "{{ route('checkEmail') }}", type: "post", data: {'_token': '{{ csrf_token() }}'}},
                },
            }, {
                email: {
                    required: "Please enter a email",
                    email: "Please enter a valid email address",
                    remote: 'This email address is not registered with us'
                },
            });
            $('.forgot-password').on('click', function (e) {
                e.preventDefault();
                let form = $('#forgotPassword');
                let email = $('#email').val();
                if (form.valid()) {
                    ajaxCall('{{ route('forgotPassword') }}',
                        {
                            email: email,
                        },
                        'POST', true).then(function (response) {
                        if (response.status === true) {
                            toastMsg({message: response.message, timer: 5000});
                            form.trigger('reset');
                        } else {
                            if (response.errors) {
                                const firstErrorMessage = Object.values(response.errors)[0][0];
                                toastMsg({message: firstErrorMessage, timer: 3000, icon: 'error'});
                            } else {
                                toastMsg({message: response.message, timer: 3000, icon: 'info'});
                            }
                        }
                    }).catch(function (error) {
                        Swal.fire({
                            title: 'Wait!',
                            text: "You have exceeded the allowed number of password reset attempts. Please try again after 1 minute.",
                            icon: 'info',
                            width: '430',
                        })
                    });
                }
            });
        });
    </script>
@endpush