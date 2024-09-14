@extends('admin.layout.app')

@section('title', $isEdit ? 'Update User' : 'Edit User')

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Users', 'link' => route('users.index'), 'addOrEdit' => $isEdit ? 'edit' : 'add'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $isEdit ? 'Edit User' : 'Add User' }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="UserForm" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}" method="post">
                                    @csrf
                                    @isset($user)
                                        @method('PUT')
                                        <input type="hidden" id="user_id" name="id" value="{{$user->id}}">
                                    @endisset
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" value="{{ old('name', ($isEdit ? $user->name : '')) }}"
                                                   class="form-control">
                                            @error('name')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="number">Phone Number</label>
                                            <input type="text" value="{{ old('number', ($isEdit ? $user->number : '')) }}" id="number" name="number" class="form-control">
                                            @error('number')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" value="{{ old('email', ($isEdit ? $user->email : '')) }}"
                                                   class="form-control">
                                            @error('email')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password">Password</label>
                                            <input type="text" id="password" name="password" value="{{ old('password') }}"
                                                   class="form-control">
                                            @error('password')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="status">User Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option selected="" disabled="">Select Status</option>
                                                @foreach(getConstant("STATUS") as $key => $value)
                                                    <option @selected(old('status', ($isEdit ? $user->status : '')) == $key)
                                                            value="{{ $key }}">{{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="user_type">User Type</label>
                                            <select id="user_type" name="user_type" class="form-control">
                                                <option selected="" disabled="">Select Type</option>
                                                <option @selected(old('user_type', ($isEdit ? $user->user_type : '')) == 'user') value="user">User</option>
                                                <option @selected(old('user_type', ($isEdit ? $user->user_type : '')) == 'admin') value="admin">Admin</option>
                                            </select>
                                            @error('user_type')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="address">Address</label>
                                            <textarea rows="5" type="text" id="address" name="address"
                                                      class="form-control">{{ old('address', ($isEdit ? $user->address : '')) }}</textarea>
                                            @error('description')
                                            <p class="mt-1 custom-error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                                            <input type="submit" value="Save" class="btn btn-success float-right">
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
@endsection

@push('scripts')
    <script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    <script>
        $(function () {
            const isEdit = '{{ $isEdit ? true : false }}';
            validateRequest('UserForm', {
                name: {
                    required: true,
                },
                email: {
                    email: true,
                    required: true,
                    remote: {url: "{{ url('admin/check-duplicate') }}", type: "post",data:{'_token': '{{ csrf_token() }}', id:$("#user_id").val() }}
                },
                number: {
                    required: true,
                    minlength: 10,
                    remote: {url: "{{ url('admin/check-duplicate') }}", type: "post",data:{'_token': '{{ csrf_token() }}', id:$("#user_id").val() }}
                },
                user_type: {
                    required: true,
                },
                status: {
                    required: true
                },
                password: {
                    required: isEdit ? false : true,
                    minlength: 8,
                }
            }, {
                name: {
                    required: "Please enter a name",
                },
                email: {
                    required: "Please enter a email",
                    email: "Please enter a valid email address",
                    remote: "This email is already taken!"
                },
                number: {
                    required: "Please enter a 10 digit mobile number",
                    minlength: "Please enter at least 10 digits",
                    remote: "This mobile number is already taken!"
                },
                user_type: {
                    required: "Please select user type",
                },
                status: {
                    required: "Please select status",
                },
                password: {
                    required: "Please enter a password",
                    minlength: "Please enter at least 8 characters",
                },
            });
        });
    </script>
@endpush
