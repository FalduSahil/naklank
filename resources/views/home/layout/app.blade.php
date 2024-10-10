<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') {{ getConstant('SITE_NAME') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ getPath('common') }}/images/64-round.png"/>
    <link href="{{ getPath('home') }}/libs/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/feather-webfont/dist/feather-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ getPath('home') }}/css/theme.min.css"/>

    @stack('styles')
</head>

<body>

@include('home.includes.nav')

<main>
    @yield('content')
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fs-3 fw-bold" id="userModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="placeOrder">
                        <input type="hidden" name="product_id" id="productId" class="product-id">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xxl-6">
                                <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"  name="name" class="form-control" id="name" placeholder="Enter Your Name"/>
                        </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xxl-6">
                                <div class="mb-3">
                            <label for="quantity" class="form-label product-name"></label>
                            <input type="text" name="quantity" class="form-control" id="quantity" value="1" placeholder="Enter Quantity"/>
                        </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                            <label for="number" class="form-label">Phone Number</label>
                            <input type="text" name="number" class="form-control" id="number" placeholder="Enter Mobile Number"/>
                        </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email Address"/>
                        </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-5">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" cols="4" rows="4" id="address" placeholder="Enter Your Address"></textarea>
                        </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary place-order">Order Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@include('home.includes.footer')


<script src="{{ getPath('home') }}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ getPath('home') }}/libs/simplebar/dist/simplebar.min.js"></script>
<script src="{{ getPath('home') }}/js/theme.min.js"></script>
<script src="{{ getPath('home') }}/js/vendors/jquery.min.js"></script>
<script src="{{ getPath('common') }}/js/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="{{ getPath('common') }}/js/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="{{ getPath('common') }}/js/custom/custom.js"></script>
<script>
    $(function () {
        ajaxSetup();

        $(document).on('click', '.openModal', function () {
            let name = `Quantity For ` + $(this).attr('data-name');
            let productId = $(this).attr('data-id');
            $('.product-name').html(name);
            $('.product-id').val(productId);
            $('#quantity').val($('#productQuantity').val());
            $('#userModal').modal('show');
        });

        validateRequest('placeOrder', {
                name: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                },
                number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                },
                quantity: {
                    required: true,
                    digits: true,
                    minlength: 1,
                },
            }, {
                name: {
                    required: "Please enter your name"
                },
                email: {
                    required: "Please enter a email",
                    email: "Please enter a valid email address",
                },
                number: {
                    required: "Please your number",
                    minlength: "Please enter at least 10 digits",
                },
                quantity: {
                    required: "Please your quantity",
                    minlength: "Please enter value greater then 0",
                },
            });

        $('.place-order').on('click', function (e) {
                e.preventDefault();
                $(this).prop('disabled', true);
                let $this = $(this);
                let form = $('#placeOrder');
                if (form.valid()) {
                    let email = $('#email').val();
                    let number = $('#number').val();
                    let name = $('#name').val();
                    let address = $('#address').val();
                    let productId = $('#productId').val();
                    let quantity = $('#quantity').val();
                    ajaxCall('{{ route('placeOrderWeb') }}',
                        {
                            name: name,
                            email: email,
                            number: number,
                            address: address,
                            product_id: productId,
                            quantity: quantity
                        },
                        'POST', true).then(function (response) {
                        if (response.status === true) {
                            $('#userModal').modal('hide');
                            $this.removeAttr('disabled');
                            $('#placeOrder').trigger("reset");
                            Swal.fire({
                                title: "Good job!",
                                text: response.message,
                                icon: "success"
                            });
                        } else {
                            $this.removeAttr('disabled');
                            if(response.errors){
                                const firstErrorMessage = Object.values(response.errors)[0][0];
                                toastMsg({ message: firstErrorMessage, timer: 3000, icon: 'error' });
                            } else {
                                toastMsg({ message: response.message, timer: 3000, icon: 'info' });
                            }
                        }
                    });
                }
            });
    })
</script>
@stack('scripts')
</body>
</html>