@extends('admin.layout.app')

@php($isView = request()->routeIs('products.show') ?? false)

@section('title', $isEdit ? 'Edit Product' : ($isView ? 'View Product' : 'Add Product'))

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/dropzone/dropzone.min.css" type="text/css"/>
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Products', 'link' => route('products.index'), 'addOrEdit' => $isEdit ? 'edit' : ($isView ? 'show' : 'add'), 'name' => $product->name ?? null])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $isEdit ? 'Edit' : ($isView ? 'View' : 'Add') }} Product</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="Product" action="{{ $isEdit ? route('products.update', $product) : route('products.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @isset($product)
                                        @method('PUT')
                                        <input type="hidden" id="product_id" name="id" value="{{$product->id}}">
                                    @endisset
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Product Name</label>
                                            <input type="text" id="name" name="name" value="{{ old('name', ($isEdit || $isView ? $product->name : '')) }}" class="form-control">
                                            @error('name')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="slug">Product Slug</label>
                                            <input type="text" id="slug" name="slug" value="{{ old('slug', ($isEdit || $isView ? $product->slug : '')) }}" class="form-control">
                                            @error('slug')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="description">Product Description</label>
                                            <textarea rows="5" type="text" id="description" name="description"
                                                      class="form-control">{{ old('description', ($isEdit || $isView ? $product->description : '')) }}</textarea>
                                            @error('description')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="category_id">Product Category</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option selected="" disabled="">Select Category</option>
                                                @foreach(getCategories() as $category)
                                                    <option @selected(old('category_id', ($isEdit || $isView ? $product->getCategory->id : '')) == $category->id) value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="price">Product Price</label>
                                            <input min="1" type="number" value="{{ old('price', ($isEdit || $isView ? $product->price : '')) }}" id="price" name="price" class="form-control">
                                            @error('price')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="quantity">Quantity</label>
                                            <input min="1" type="number" id="quantity" name="quantity" value="{{ old('quantity', ($isEdit || $isView ? $product->quantity : '')) }}" class="form-control">
                                            @error('quantity')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="status">Product Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option selected="" disabled="">Select Status</option>
                                                @foreach(getConstant("STATUS") as $key => $value)
                                                    <option @selected(old('status', ($isEdit || $isView ? $product->status : '')) == $key) value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="selectimage">Product Images</label>
                                            <div class="input-group">
                                                <a @if(request()->routeIs('products.show') !== true) disabled @endif href="javascript:void(0);"
                                                   @class(['form-control', 'text-decoration-none', 'bg-secondary' => request()->routeIs('products.show'), 'bg-gradient'])
                                                   id="selectimage">Upload Images</a>
                                                <input type="hidden" name="images" id="images" value="" />
                                            </div>
                                            @error('images')
                                            <p class="mt-1 custom-error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="mainImage">Display Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="main_image" class="custom-file-input" id="mainImage">
                                                    <label class="custom-file-label" for="mainImage">Choose file</label>
                                                </div>
                                            </div>
                                            @error('main_image')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        @isset($product)
                                            <div class="form-group col-2">
                                                <img class="rounded" height="100" width="100"
                                                     src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}">
                                            </div>
                                        @endisset
                                    </div>
                                    <div class="row">
                                        @isset($product)
                                            <ul class="ps-0 list-unstyled list-inline pt-4 col-lg-11 col-xl-10">
                                                @foreach($product->getProductImages as $images)
                                                    <li id="removeId_{{ $images->id }}"
                                                        class="upload-image-fix list-inline-item">
                                                        <div class="dz-details">
                                                            <img class="preview-image rounded mx-auto d-block"
                                                                 src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$images->image) }}"/>
                                                            @if(request()->routeIs('products.show') !== true)
                                                            <a href="javascript:void(0);" data-id="{{ $images->id }}"
                                                               class="btn btn-sm btn-danger text-decoration-none px-5 mt-2 mb-2 delete-product-image"
                                                               onclick="" title="Delete Product Image">Delete</a>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endisset
                                            @if(request()->routeIs('products.show') !== true)
                                                <div class="form-group col-12">
                                                    <div class="pw dropzone"></div>
                                                </div>
                                            @endif
                                    </div>
                                    @if(request()->routeIs('products.show') !== true)
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('products.index') }}"
                                                   class="btn btn-secondary">Cancel</a>
                                                <input type="submit" value="Save" class="btn btn-success float-right">
                                            </div>
                                        </div>
                                    @endif
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
    <script src="{{ getPath('admin') }}/plugins/dropzone/dropzone.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        bsCustomFileInput.init();
        $(function () {
            ajaxSetup();
            validateRequest('Product', {
                name: {
                    required: true,
                },
                product_code: {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                label_id: {
                    required: true,
                },
                description: {
                    required: true,
                },
                price: {
                    required: true,
                    min: 1,
                },
                product_for: {
                    required: true,
                },
                slug: {
                    required: true,
                    remote: {
                        url: '{{ route('validateSlug') }}',
                        method: 'POST',
                        data: {
                            'product_id': '{{ $product->id ?? '' }}',
                            '_token': '{{ csrf_token() }}'
                        },
                    },
                },
                quantity: {
                    required: true,
                    min: 1,
                },
                per_box_quantity: {
                    required: true,
                    min: 1,
                },
                image : {
                    required: true,
                },
                status: {
                    required: true
                }
            }, {
                name: {
                    required: "Please enter a name",
                },
                category_id: {
                    required: "Please select one category",
                },
                product_code: {
                    required: "Please enter product code",
                },
                label_id: {
                    required: "Please select one label",
                },
                image: {
                    required: "Please upload a image",
                },
                quantity: {
                    required: "Please enter quantity",
                },
                per_box_quantity: {
                    required: "Please enter per box pieces",
                },
                price: {
                    required: "Please enter price",
                },
                description: {
                    required: "Please enter product description",
                },
                status: {
                    required: "Please select status",
                },
                product_for: {
                    required: "Please select product for",
                },
            });
            /*DropZone*/
            var fileList = [];
            $("#selectimage").dropzone({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('uploadImages') }}",
                paramName: "productImages",
                parallelUploads:1,
                uploadMultiple: true,
                maxFilesize: 2,
                addRemoveLinks: true,
                previewsContainer: '.pw',
                acceptedFiles: 'image/png,image/jpg,image/jpeg',
                accept: function (file, done){
                    done();
                },
                success : function(file, response){
                    fileList[file.name] = {"fid" : response };
                    let filestr = $("#images").val();
                    if (filestr != '')
                        filestr = filestr + '::' + response;
                    else
                        filestr = response;
                    $("#images").val(filestr);
                },
                removedfile: function (file) {
                    $.post('{{ route("removeTempFiles") }}?file=' + fileList[file.name].fid, function (retdata) {
                        let filesUploaded = $("#images").val();
                        let fileArr = filesUploaded.split("::");
                        if(jQuery.inArray(fileList[file.name].fid.toString(), fileArr) !== -1){
                            fileArr = jQuery.grep(fileArr, function(value) {
                                return value != fileList[file.name].fid;
                            });
                            let fileStr = fileArr.join("::");
                            $("#images").val(fileStr);
                        }
                        let _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    });
                }
            });
            $('#slug').on('click', function () {
                let categoryName = $('#name').val(),
                    slug = categoryName.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $(this).val(slug);
            });
            /*Delete Image*/
            $(document).on('click', '.delete-product-image',function () {
               let productId = $(this).data('id');
                ajaxCall('{{ route('removeImage') }}', {'productId': productId}, 'POST', true).then(function (response) {
                    if(response.status === true){
                        $('#removeId_'+productId).remove();
                        toastMsg({message: response.message, timer: 2000});
                    }
                });
            });
        });
    </script>
    @if($isEdit === false && request()->routeIs('products.show'))
        <script>
            $(function () {
                $("input, textarea, select").prop("disabled", true);
            });
        </script>
    @endif
@endpush
