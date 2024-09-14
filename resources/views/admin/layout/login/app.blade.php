<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ getConstant('SITE_NAME') }} | Admin Log in</title>
    <link rel="shortcut icon" href="{{ getPath('admin') }}/img/64.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
@yield('content')
<script src="{{ getPath('admin') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ getPath('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ getPath('admin') }}/js/adminlte.min.js"></script>
<script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
<script>
    $(function (){
        $('#loginForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>
</body>
</html>
