@extends('admin.layout.app')

@section('title', 'Edit Category')

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Categories', 'link' => route('categories.index'), 'addOrEdit' => 'edit'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Category</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="editCategoryForm" action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $category->id }}">
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="name">Category Name</label>
                                            <input type="text" id="name" name="name" value="{{ $category->name }}"
                                                   class="form-control">
                                            @error('name')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="status">Category Status</label>
                                            <select id="status" name="status" class="form-control custom-select">
                                                <option selected="" disabled="">Select Status</option>
                                                <option value="active" @selected($category->status == 'active')>Active</option>
                                                <option value="inactive" @selected($category->status == 'inactive')>Inactive</option>
                                            </select>
                                            @error('status')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="slug">Category Slug</label>
                                            <input type="text" id="slug" name="slug" value="{{ $category->slug }}" class="form-control">
                                            @error('slug')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="description">Category Description</label>
                                            <textarea rows="5" type="text" id="description" name="description"
                                                      class="form-control">{{ $category->description }}</textarea>
                                            @error('description')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="selectimage">Category Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="selectimage">
                                                    <label class="custom-file-label" for="selectimage">Choose file</label>
                                                </div>
                                            </div>
                                            @error('image')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        @isset($category->image)
                                            <div class="form-group col-6">
                                                <img class="rounded" height="100" width="100" src="{{ asset(getConstant('CATEGORY_IMAGE_PATH').$category->image) }}">
                                            </div>
                                        @endisset
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ getPath('admin') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
            validateRequest('editCategoryForm', {
                name: {
                    required: true,
                },
                description: {
                    required: true,
                },
                slug: {
                    required: true,
                    remote: {
                        url: '{{ route('validateSlug') }}',
                        method: 'POST',
                        data: {
                            'category_id': '{{ $category->id }}',
                            '_token': '{{ csrf_token() }}'
                        },
                    },
                },
                status: {
                    required: true
                }
            }, {
                name: {
                    required: "Please enter a name",
                },
                description: {
                    required: "Please enter description",
                },
                status: {
                    required: "Please select status",
                },
            });
        });
    </script>
@endpush
