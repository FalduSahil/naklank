@component('mail::message')
    <div style="font-size: 15px">
        Hey Admin,
        <br><br>
        New Order Received With ID: {{ $order->id }}
        <br><br>
        Here are the order details:
        <br><br>
        <strong>Order Summary:</strong>
        <br>
        <table style="border: 1px solid black; border-collapse: collapse; width: 100%;">
            <thead>
            <tr>
                <th style="border: 1px solid black; text-align: center;">Product</th>
                <th style="border: 1px solid black; text-align: center;">Box Quantity</th>
                <th style="border: 1px solid black; text-align: center;">Per Box Price</th>
                <th style="border: 1px solid black; text-align: center;">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->orderMeta as $item)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $item->product->name }}</td>
                    <td style="border: 1px solid black; text-align: center;">
                        {{ formatNumber($item->quantity) }} <br>
                        ( Per Box Piece : {{ $item->product->per_box_quantity }} )
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
    </div>
@endcomponent
