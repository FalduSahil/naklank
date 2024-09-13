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
        @include('admin.includes.bread-crumbs', ['title' => 'Products', 'link' => route('products.index'), 'addOrEdit' => 'show', 'name' => $product->name])
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="javascript:void(0)" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name">Product Name</label>
                                            <input disabled type="text" id="name" name="name" value="{{ $product->name }}" class="form-control">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="code">Product Code</label>
                                            <input disabled type="text" id="code" name="product_code" value="{{ $product->product_code }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="description">Product Description</label>
                                            <textarea disabled rows="5" type="text" id="description" name="description"
                                                      class="form-control">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-3">
                                            <label for="price">Product Price</label>
                                            <input disabled min="1" type="number" value="{{ $product->price }}" id="price" name="price" class="form-control">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="quantity">Box Quantity</label>
                                            <input disabled min="1" type="number" value="{{ $product->quantity }}" id="quantity" name="quantity" class="form-control">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="quantity">Per Box Piece</label>
                                            <input disabled min="1" type="number" value="{{ $product->per_box_quantity }}" id="quantity" name="quantity" class="form-control">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="status">Product Status</label>
                                            <select disabled id="status" name="status" class="form-control custom-select">
                                                <option selected="" disabled="">Select Status</option>
                                                <option @selected($product->status == 'active') value="active">Active</option>
                                                <option @selected($product->status == 'inactive') value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-4">
                                            <label for="category">Product Category</label>
                                            <select disabled id="category" name="category_id" class="form-control custom-select">
                                                <option selected="" disabled="">Select Category</option>
                                                @foreach(getCategories() as $category)
                                                    <option @isset($product->getCategory->id) @selected($category->id == $product->getCategory->id) @endisset value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="label_id">Product Label</label>
                                            <select disabled id="label_id" name="label_id" class="form-control custom-select">
                                                <option selected="" disabled="">Select Label</option>
                                                @foreach(getLabels($product->sub_category_id) as $label)
                                                    <option @isset($product->getLabel->id) @selected($label->id == $product->label_id) @endisset value="{{ $label->id }}">{{ $label->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Product Images</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <img class="rounded" height="100" width="100" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="ps-0 list-unstyled list-inline pt-4 col-lg-11 col-xl-10">
                                            @foreach($product->getProductImages as $images)
                                                <li id="removeId_{{ $images->id }}" class="upload-image-fix list-inline-item">
                                                    <div class="dz-details">
                                                        <img class="preview-image rounded mx-auto d-block" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$images->image) }}" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="form-group col-12">
                                            <div class="pw dropzone"></div>
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
