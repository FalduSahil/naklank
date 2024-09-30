@extends('admin.layout.app')

@section('title', 'Users')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Users', 'link' => route('users.index'), 'addOrEdit' => ''])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('users.create') }}" type="button" class="btn btn-success float-right mb-4"><i class="fa fa-plus"></i> Add User</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered dataTable" id="userTable">
                                    <thead>
                                    <tr>
                                        <th class="no-sort"><span>#</span></th>
                                        <th><span>Name</span></th>
                                        <th><span>Email</span></th>
                                        <th><span>Phone Number</span></th>
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
    <script src="{{ getPath('common') }}/js/custom/custom.js"></script>
    @includeWhen(session('success'), 'admin.includes.toast', ['message' => session('edit') ? 'USER_UPDATED' : 'USER_ADDED'])
    <script>
        $(function (){
            ajaxSetup();
            let userTable = $('#userTable');
            let ajaxTable = userTable.DataTable({
                ajax: {
                    url: '{{ route('getDataTable', 'users') }}',
                    type: 'GET',
                    complete: function () {
                        $(".logoutFromAll").tooltip({
                            placement: "top",
                            title: "Logout From All Devices",
                            trigger: "hover"
                        });
                    }
                },
                processing: true,
                serverSide: true,
                scrollX: false,
                autoWidth: false,
                stateSave: false,
                responsive: true,
                paging: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email', width: '15%'},
                    {data: 'number', name: 'number', width: '15%'},
                    {data: 'status', name: 'status'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                ],
            });
            userTable.on('click', '.change-status', function () {
                let status = $(this).data('status');
                let id = $(this).data('id');
                ajaxCall('{{ route('changeStatus', 'users') }}', {'status': status, 'id': id}).then(function (response) {
                    if(response.status === true){
                        ajaxTable.ajax.reload(null, false);
                        toastMsg({message: response.message, timer: 2000});
                    }
                });
            });
            userTable.on('click', '.delete', function () {
                let id = $(this).data('id');
                let url = '{{ route("users.destroy", ":slug") }}';
                url = url.replace(':slug', id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this user!",
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
            userTable.on('click', '.logoutFromAll', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to logout this user from all devices!",
                    icon: 'warning',
                    showCancelButton: true,
                    focusConfirm: false,
                    reverseButtons: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        ajaxCall('{{ route('logoutFromAll') }}', {id: id}).then(function (response) {
                            if (response.status === true) {
                                toastMsg({message: response.message, timer: 3000});
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
