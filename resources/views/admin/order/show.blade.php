@extends('admin.layout.app')

@section('title', $order->id)

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Order Details', 'link' => route('orders.index'), 'addOrEdit' => ''])
        <div class="content">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4 class="font-weight-bold">
                            {{ getConstant('SITE_NAME') }}
                            <small class="float-right">Date: {{ $order->created_at->format('d-m-Y h:i') }}</small>
                        </h4>
                    </div>
                </div>
                <hr>
                <div class="row invoice-info">
                    <div class="col-6 invoice-col">
                        Shipping Info:
                        <br>
                        <address>
                            Name: <strong>{{ $order->name }}</strong><br>
                            Address: {{ $order->address }}<br>
                            Phone: <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a><br>
                            Email: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                        </address>
                    </div>
                    <div class="col-6">
                        <b>Order ID:</b> {{ $order->id }}<br>
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr class="text-center">
                                <th>Product</th>
                                <th>Product Image</th>
                                <th>Product Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sub_total = 0)
                            @foreach($order->orderMeta as $products)
                                <tr class="text-center">
                                    <td>
                                        {{ $products->product->name }}
                                    </td>
                                    <td>
                                        <img class="rounded mx-3" height="70" width="70" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$products->product->main_image) }}">
                                    </td>
                                    <td>{{ '₹'.formatNumber($products->product->price) }}</td>
                                    <td>{{ $products->quantity }}</td>
                                    <td>{{ '₹'.formatNumber($products->sub_total) }}</td>
                                </tr>
                                @php($sub_total += (int)$products->sub_total)
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th style="width:83%">Subtotal:</th>
                                    <td>{{ '₹'.formatNumber($sub_total) }}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{ '₹'.formatNumber($order->total) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-12">
                        <a onclick="window.print()" href="javascript:void(0)" rel="noopener" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
