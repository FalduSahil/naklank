@component('mail::message')
    <div style="font-size: 15px">
        Hey Admin,
        <br><br>
        New inquiry from {{ $inquiry->first_name }} {{ $inquiry->last_name }}. Here are the inquiry details:
        <br><br>
        <strong>Name:</strong> {{ $inquiry->first_name }} {{ $inquiry->last_name }}
        <br><br>
        <strong>Mobile Number:</strong> <a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a>
        <br><br>
        <strong>Email:</strong> {{ $inquiry->email }}
        <br><br>
        <strong>Message:</strong> {{ $inquiry->message }}
        <br><br>
    </div>
@endcomponent
