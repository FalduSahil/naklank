@extends('admin.layout.app')

@section('title', 'Orders')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Orders', 'link' => route('orders.index'), 'addOrEdit' => ''])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('orders.create') }}" type="button"
                           class="btn btn-success float-right mb-4"><i class="fa fa-plus"></i> Add Order</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered dataTable" id="orderTable">
                                    <thead>
                                    <tr>
                                        <th><span>Order Number</span></th>
                                        <th><span>Client</span></th>
                                        <th><span>Phone</span></th>
                                        <th><span>Email</span></th>
                                        <th><span>Order Total</span></th>
                                        <th><span>Order Status</span></th>
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
    @includeWhen(session('success'), 'admin.includes.toast', ['message' => session('edit') ? 'ORDER_UPDATED' : ''])
    <script>
        $(function (){
            ajaxSetup();
            let orderTable = $('#orderTable');
            let ajaxTable = orderTable.DataTable({
                ajax: '{{ route('getDataTable', 'orders') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: false,
                stateSave: true,
                responsive: true,
                paging: true,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'client', name: 'client', width: '15%'},
                    {data: 'phone', name: 'number', width: '15%'},
                    {data: 'email', name: 'email', width: '15%'},
                    {data: 'total', name: 'total'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ]
            });
            ajaxTable.order([0, 'desc']);
            orderTable.on('click', '.change-status', function () {
                let status = $(this).data('status');
                let id = $(this).data('id');
                if(status == 'rejected') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this order!",
                        icon: 'warning',
                        showCancelButton: true,
                        focusConfirm: false,
                        reverseButtons: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            ajaxCall('{{ route('updateOrderStatus') }}', {'status': status, 'id': id}, 'POST', true).then(function (response) {
                                if(response.status === true){
                                    ajaxTable.ajax.reload(null, false);
                                    toastMsg({message: response.message, timer: 2000});
                                }
                            });
                        }
                    });
                } else {
                    ajaxCall('{{ route('updateOrderStatus') }}', {'status': status, 'id': id}, 'POST', true).then(function (response) {
                        if(response.status === true){
                            ajaxTable.ajax.reload(null, false);
                            toastMsg({message: response.message, timer: 2000});
                        }
                    });
                }
            });
            orderTable.on('click', '.delete', function () {
                let id = $(this).data('id');
                let url = '{{ route("orders.destroy", ":slug") }}';
                url = url.replace(':slug', id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this order!",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ajaxCall(url, {},'DELETE', true).then(function (response) {
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
