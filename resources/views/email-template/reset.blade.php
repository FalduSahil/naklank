@component('mail::message')
    <div>
        <p>
            Hello,
            <br>
            <br>
            You have requested a password reset. Here are your login details:
            <br>
            <br>
            Email: {{ $data['email'] }}
            <br>
            <br>
            Temporary Password: <b>{{ $data['password'] }}</b>
            <br>
            <br>
            You can log in using the following link:
            <br>
            <br>
            <a href="{{ $data['loginLink'] }}">Log In</a>
            <br>
            <br>
            <b>Please remember to update your password after login.</b>
            <br>
            <br>
            If you didn't request this password reset, please ignore this email.
        </p>
    </div>
@endcomponent
