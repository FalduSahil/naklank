@component('mail::message')
    <div style="font-size: 15px">
        Hey {{ $order->name }},
        <br><br>
        Your Order has been received. Here are the order details:
        <br><br>
        <strong>Order Summary:</strong>
        <br>
        <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
            <thead>
            <tr>
                <th style="border: 1px solid black; text-align: center;">Product</th>
                <th style="border: 1px solid black; text-align: center;">Quantity</th>
                <th style="border: 1px solid black; text-align: center;">Price</th>
                <th style="border: 1px solid black; text-align: center;">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderMeta as $item)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->product->name }}</td>
                    <td style="border: 1px solid black; text-align: center;">
                        {{ formatNumber($item->quantity) }} <br>
                    </td>
                    <td style="border: 1px solid black; text-align: center;">
                        &#8377;{{ formatNumber($item->product->price) }}</td>
                    <td style="border: 1px solid black; text-align: center;">
                        &#8377;{{ formatNumber($item->sub_total) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;"></td>
                <td style="border: 1px solid black; text-align: center;"><strong>Total:</strong></td>
                <td style="border: 1px solid black; text-align: center;">
                    <strong>&#8377;{{ formatNumber($order->total) }}</strong></td>
            </tr>
            </tfoot>
        </table>
        <br><br>
        <strong>Order Information:</strong>
        <br><br>
        <strong>Name:</strong> {{ $order->name }}
        <br><br>
        <strong>Mobile Number:</strong> {{ $order->phone }}
        <br><br>
        <strong>Email:</strong> {{ $order->email }}
        <br><br>
        <strong>Address:</strong> {{ $order->address }}
        <br><br>
        Please note that this order is not confirmed yet. We will contact you again once the order is confirmed. If you
        have any questions or concerns, feel free to contact us.
        <br><br>
    </div>
@endcomponent
