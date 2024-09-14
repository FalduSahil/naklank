@extends('admin.layout.app')

@section('title', 'Inquiries')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Inquiries', 'link' => route('inquiries.index'), 'addOrEdit' => ''])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered dataTable" id="userTable">
                                    <thead>
                                    <tr>
                                        <th><span>#</span></th>
                                        <th><span>Name</span></th>
                                        <th><span>Email</span></th>
                                        <th><span>Mobile Number</span></th>
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
    @includeWhen(session('success'), 'admin.includes.toast', ['message' => 'INQUIRY_DELETED'])
    <script>
        $(function (){
            ajaxSetup();
            let userTable = $('#userTable');
            let ajaxTable = userTable.DataTable({
                ajax: '{{ route('getDataTable', 'inquiries') }}',
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: false,
                stateSave: true,
                responsive: true,
                paging: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'name', name: 'name', width: '30%'},
                    {data: 'email', name: 'email', width: '30%'},
                    {data: 'phone', name: 'number', width: '30%'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false, width: '5%'},
                ]
            });
            ajaxTable.order([0, 'desc']);
            userTable.on('click', '.delete', function () {
                let id = $(this).data('id');
                let url = '{{ route("inquiries.destroy", ":slug") }}';
                url = url.replace(':slug', id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this inquiry!",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ajaxCall(url, {},'DELETE').then(function (response) {
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
