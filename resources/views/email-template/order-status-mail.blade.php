@component('mail::message')
    <div style="font-size: 15px">
        Hey {{ $order->user->name }},
        <br><br>
        Your Order #{{ $order->order_number }} status has been changed to {{ ucfirst($order->status) }}.
        <br><br>
        If you have any questions or concerns, feel free to contact us.
        <br><br>
    </div>
@endcomponent
