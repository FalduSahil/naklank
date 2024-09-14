@extends('admin.layout.app')

@section('title', 'Edit Order')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/select2/css/select2.min.css" type="text/css"/>
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Orders', 'link' => route('orders.index'), 'addOrEdit' => 'edit'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Order</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="editOrderForm" action="{{ route('orders.update', $order->id) }}" method="post" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="font-weight-bold">
                                                Order No. : {{ $order->id }}
                                            </h4>
                                            <br>
                                        </div>
                                        <div class="col-6">
                                            <a href="javascript:void(0)" type="button" data-toggle="modal" data-target="#addProductModal" class="btn btn-success float-right addProduct"><i class="fa fa-plus"></i> Add Products</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <hr>
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Image</th>
                                                    <th>Code</th>
                                                    <th>Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Subtotal</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="orderTableBody">
                                                @php
                                                    $sub_total = 0;
                                                @endphp
                                                @foreach($order->orderMeta as $products)
                                                    <tr class="product-row" data-product-id="{{ $products->product->id }}">
                                                        <td>
                                                            {{ $products->product->name }}
                                                        </td>
                                                        <td>
                                                            <img class="rounded mx-3" height="70" width="70" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$products->product->main_image) }}" alt="">
                                                        </td>
                                                        <td>{{ $products->product->product_code }}</td>
                                                        <td class="price">{{ '₹'.formatNumber($products->product->price) }}</td>
                                                        <td style="width: 160px" class="text-center form-group">
                                                            <input type="number" class="form-control quantity-input" min="1" value="{{ $products->quantity }}">
                                                        </td>
                                                        <td class="text-center subtotal">{{ '₹'.formatNumber($products->sub_total) }}</td>
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-danger delete-product"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $sub_total += (int)$products->sub_total;
                                                    @endphp
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
                                                        <td class="float-right">Total: <span class="font-weight-bold" id="total">{{ '₹'.formatNumber($order->total) }}</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                                            <a href="javascript:void(0)" class="btn btn-success float-right" onclick="updateOrder()">Update</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Products</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="products">Products</label>
                                        <br>
                                        <select style="width: 100%" id="products" name="products[]" class="form-control col-12 select2" multiple="">
                                            @foreach($all_products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="addProductToOrder">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    <script src="{{ getPath('admin') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        function updateSubtotals() {
            let total = 0;

            $('.product-row').each(function () {
                const row = $(this);
                const quantity = parseInt(row.find('.quantity-input').val(), 10);
                const price = parseInt(row.find('.price').text().replace(/[^0-9.]/g, ''));
                const subtotal = quantity * price;

                row.find('.subtotal').text('₹' + subtotal.toLocaleString('en-IN'));

                total += subtotal;
            });

            $('#total').text('₹' + total.toLocaleString('en-IN'));
        }

        function updateOrder() {
            const orderId = '{{ $order->id }}';

            const productData = [];

            $('.product-row').each(function () {
                const row = $(this);
                const productId = row.data('product-id');
                const quantity = parseInt(row.find('.quantity-input').val(), 10);
                productData.push({'product_id': productId, quantity });
            });

            if(productData.length === 0){
                toastMsg({message: 'Please Add Some Products!', timer: 3000, icon: 'info'});
                return;
            }

            ajaxCall('{{ route('updateOrder') }}', {'order_id': orderId, 'order_data': productData }, 'POST').then(function (response) {
                if (response.status === true) {
                    Swal.fire({
                        title: response.message,
                        icon: "success"
                    });
                    setTimeout(function (){
                        window.location.href = response.url;
                    }, 2000);
                } else {
                    toastMsg({message: response.message, timer: 3000, icon: 'info'});
                }
            });
        }

        $(function () {
            ajaxSetup();

            let orderTable = $('#orderTableBody');

            let addProductModal = $('#addProductModal');

            $('.select2').select2({
                placeholder: 'Select Products'
            });

            orderTable.on('change', '.quantity-input', function () {
                let $this = $(this);
                const row = $this.closest('.product-row');
                const newQuantity = parseInt($this.val(), 10) || 0;
                const productId = row.data('product-id').toString();
                const orderId = '{{ $order->id }}';

                ajaxCall('{{ route('checkQuantity') }}', {'product_id': productId, 'quantity': newQuantity, 'order_id': orderId}, 'POST', false).then(function (response) {
                    if(response.status === false){
                        $this.val(response.quantity);
                        toastMsg({message: response.message, timer: 3000, icon: 'info'});
                    }
                    updateSubtotals();
                });
            });

            orderTable.on('click', '.delete-product', function () {
                const row = $(this).closest('.product-row');
                row.remove();
                updateSubtotals();
            });

            $('#addProductToOrder').on('click', function () {
                let selectedValue = $('.select2').val();

                let existingProducts = orderTable.find('.product-row').map(function () {
                    return $(this).data('product-id').toString();
                }).get();

                let newProducts = selectedValue.filter(productId => !existingProducts.includes(productId));

                if (newProducts.length === 0) {
                    addProductModal.modal('hide');
                    $('.select2').val(null).trigger('change');
                    toastMsg({message: 'Product Already In Order', timer: 3000, icon: 'info'});
                    return;
                }

                ajaxCall('{{ route('addProducts') }}', {'product_id': newProducts}, 'POST').then(function (response) {
                    if (response.status === true) {
                        $('.select2').val(null).trigger('change');
                        orderTable.append(response.html);
                        updateSubtotals();
                        addProductModal.modal('hide');
                    } else {
                        addProductModal.modal('hide');
                    }
                });
            });
        });
    </script>
@endpush
