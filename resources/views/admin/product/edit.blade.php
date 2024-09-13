@extends('admin.layout.app')

@section('title', 'Edit Products')

@push('styles')
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/dropzone/dropzone.min.css" type="text/css"/>
    <link rel="stylesheet" href="{{ getPath('admin') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
@endpush

@section('content')
    <div class="content-wrapper">
        @include('admin.includes.bread-crumbs', ['title' => 'Products', 'link' => route('products.index'), 'addOrEdit' => 'edit'])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Product</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="editProduct" action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Product Name</label>
                                            <input type="text" id="name" name="name" value="{{ $product->name }}" class="form-control">
                                            @error('name')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="code">Product Code</label>
                                            <input type="text" id="code" name="product_code" value="{{ $product->product_code }}" class="form-control">
                                            @error('product_code')
                                            <p class="mt-1 custom-error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="description">Product Description</label>
                                            <textarea rows="5" type="text" id="description" name="description"
                                                      class="form-control">{{ $product->description }}</textarea>
                                            @error('description')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="price">Product Price</label>
                                            <input min="1" type="number" value="{{ $product->price }}" id="price" name="price" class="form-control">
                                            @error('price')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="quantity">Box Quantity</label>
                                            <input min="1" type="number" value="{{ $product->quantity }}" id="quantity" name="quantity" class="form-control">
                                            @error('quantity')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="quantity">Per Box Piece</label>
                                            <input min="1" type="number" value="{{ $product->per_box_quantity }}" id="per_box_quantity" name="per_box_quantity" class="form-control">
                                            @error('per_box_quantity')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="status">Product Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option selected="" disabled="">Select Status</option>
                                                <option @selected($product->status == 'active') value="active">Active</option>
                                                <option @selected($product->status == 'inactive') value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="category_id">Product Category</label>
                                            <select id="category_id" name="category_id" class="form-control">
                                                <option hidden="" disabled="">Select Category</option>
                                                @foreach(getCategories() as $category)
                                                    <option @isset($product->getCategory->id) @selected($category->id == $product->getCategory->id)@endisset value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="label_id">Product Label</label>
                                            <select id="label_id" name="label_id" class="form-control">
                                                <option hidden="" disabled="">Select Label</option>
                                                @foreach(getLabels($product->sub_category_id) as $label)
                                                    @if($label->category_id == $product->category_id)
                                                    <option @isset($product->getLabel->id) @selected($label->id == $product->label_id) @endisset value="{{ $label->id }}">{{ $label->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('label_id')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="product_for">Product For</label>
                                            <select id="product_for" name="product_for" class="form-control">
                                                <option selected="" disabled="">Select Product For</option>
                                                @foreach(getConstant("PRODUCT_FOR") as $key => $value)
                                                    <option @selected($product->product_for == $value) value="{{ $value }}">{{ ucfirst($value) }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_for')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="slug">Product Slug</label>
                                            <input type="text" id="slug" name="slug" value="{{ $product->slug }}" class="form-control">
                                            @error('slug')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
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
                                        <div class="form-group col-2">
                                            <img class="rounded" height="100" width="100" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="selectimage">Product Images</label>
                                            <div class="input-group">
                                                <a href="javascript:void(0);" class="form-control text-decoration-none" id="selectimage">Upload Images</a>
                                                <input type="hidden" name="images" id="images" value="" />
                                            </div>
                                            @error('images')
                                            <p class="mt-1 custom-error">{{ $message  }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="ps-0 list-unstyled list-inline pt-4 col-lg-11 col-xl-10">
                                            @foreach($product->getProductImages as $images)
                                                <li id="removeId_{{ $images->id }}" class="upload-image-fix list-inline-item">
                                                    <div class="dz-details">
                                                        <img class="preview-image rounded mx-auto d-block" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$images->image) }}" />
                                                        <a href="javascript:void(0);" data-id="{{ $images->id }}" class="btn btn-sm btn-danger text-decoration-none px-5 mt-2 mb-2 delete-product-image" onclick="" title="Delete Product Image">Delete</a>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="form-group col-12">
                                            <div class="pw dropzone"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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
    <script src="{{ getPath('admin') }}/plugins/dropzone/dropzone.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ getPath('admin') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ getPath('admin') }}/custom/js/custom.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        bsCustomFileInput.init();
        $(function () {
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

            /*Form Validation*/
            ajaxSetup();
            validateRequest('editProduct', {
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
                product_for: {
                    required: true,
                },
                price: {
                    required: true,
                    min: 1,
                },
                slug: {
                    required: true,
                    remote: {
                        url: '{{ route('validateSlug') }}',
                        method: 'POST',
                        data: {
                            'product_id': '{{ $product->id }}',
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
                slug: {
                    required: "Please enter slug",
                },
                quantity: {
                    required: "Please enter box quantity",
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
            });

            /*Get Labels By SubCategory*/
            $('#category_id').on('change', function () {
                let $select = $(this);
                let $labels = $('#label_id');
                let $selectedValue = $select.val();
                ajaxCall('{{ route('getLabels') }}', {'category_id': $selectedValue}, 'POST').then(function (response) {
                    if(response.status === true){
                        $labels.empty();
                        if(response.html === ''){
                            $labels.append('<option value="">No Labels Available</option>');
                        } else {
                            $labels.append(response.html);
                        }
                    }
                });
            });
        });
    </script>
@endpush
