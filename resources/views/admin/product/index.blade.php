@extends('admin.layout.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
          href="{{ getPath('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Products', 'link' => route('products.index'), 'addOrEdit' => ''])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('products.create') }}" type="button" class="btn btn-success float-right mb-4"><i
                                class="fa fa-plus"></i> Add Product</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered dataTable" id="productsTable">
                                    <thead>
                                    <tr>
                                        <th><span>#</span></th>
                                        <th><span>Name</span></th>
                                        <th><span>Stock</span></th>
                                        <th><span>Price</span></th>
                                        <th><span>Category</span></th>
                                        <th><span>Status</span></th>
                                        <th><span>Actions</span></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ getPath('admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    @includeWhen(session('success'), 'admin.includes.toast', ['message' => session('edit') ? 'PRODUCT_UPDATED' : 'PRODUCT_ADDED'])
    <script>
        $(function () {
            ajaxSetup();
            let productsTable = $('#productsTable');
            let ajaxTable = productsTable.DataTable({
                ajax: '{{ route('getDataTable', 'products') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: false,
                stateSave: true,
                responsive: true,
                paging: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'category', name: 'category'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });
            ajaxTable.order([0, 'desc']);
            productsTable.on('click', '.change-status', function () {
                let status = $(this).data('status');
                let id = $(this).data('id');
                ajaxCall('{{ route('changeStatus', 'products') }}', {
                    'status': status,
                    'id': id
                }).then(function (response) {
                    if (response.status === true) {
                        ajaxTable.ajax.reload(null, false);
                        toastMsg({message: response.message, timer: 2000});
                    } else {
                        ajaxTable.ajax.reload(null, false);
                        toastMsg({message: response.message, timer: 4000, icon: 'error'});
                    }
                });
            });
            productsTable.on('click', '.delete', function () {
                let id = $(this).data('id');
                let url = '{{ route("products.destroy", ":slug") }}';
                url = url.replace(':slug', id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this product!",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ajaxCall(url, {}, 'DELETE').then(function (response) {
                            if (response.status === true) {
                                ajaxTable.ajax.reload(null, false);
                                toastMsg({message: response.message, timer: 2000});
                            } else {
                                toastMsg({message: response.message, timer: 2000, icon: 'error'});
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush
