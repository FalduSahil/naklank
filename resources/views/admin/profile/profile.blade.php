@extends('admin.layout.app')

@section('title', 'Profile')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Profile', 'link' => route('adminProfile'), 'addOrEdit' => ''])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{ getPath('admin') }}/img/64.png" alt="Z-Zone">
                                </div>
                                <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0)"
                                                            data-toggle="tab">Profile</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="settings">
                                        @if(session()->has('fail'))
                                            <p class="custom-error">Something Went Wrong! Please Try Again.</p>
                                        @endif
                                        <form name="updateProfile" action="{{ route('updateProfile') }}" method="POST" id="updateProfile" class="form-horizontal">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ auth()->user()->name }}">
                                                    @error('name')
                                                    <p class="custom-error">{{ $message  }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ old('email') ?? auth()->user()->email }}">
                                                    @error('email')
                                                    <p class="custom-error">{{ $message  }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Current
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" name="current_password"
                                                           id="current-password" placeholder="Current Password">
                                                    @error('current_password')
                                                    <p class="custom-error">{{ $message  }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputExperience" class="col-sm-2 col-form-label">New
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="new-password"
                                                           name="password" placeholder="New Password">
                                                    @error('password')
                                                    <p class="custom-error">{{ $message  }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Confirm
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" class="form-control" id="confirm-password"
                                                           name="password_confirmation" placeholder="Confirm Password">
                                                    @error('password_confirmation')
                                                    <p class="custom-error">{{ $message  }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-danger">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    @includeWhen(session('success'), 'admin.includes.toast', ['message' => session('edit') ? 'USER_UPDATED' : 'PROFILE_UPDATED'])
    <script>
        $(function () {
            ajaxSetup();
            validateRequest('updateProfile', {
                name: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                },
                current_password: {
                    minlength: 8,
                    remote:{ url:"{{ route('checkOldPassword') }}", type:"post", data:{'_token':'{{ csrf_token() }}'} },
                },
                password: {
                    minlength: 8,
                },
                password_confirmation: {
                    minlength: 8,
                    equalTo:"#new-password"
                },
            }, {
                current_password: {
                    minlength: "Please enter at least 8 characters",
                    remote: 'Your current password does not match with our records'
                },
                password: {
                    minlength: "Please enter at least 8 characters",
                },
                password_confirmation: {
                    minlength: "Please enter at least 8 characters",
                    equalTo: "Please enter same password as new password"
                },
            });
        });
    </script>
@endpush
