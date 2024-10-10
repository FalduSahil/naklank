@extends('home.layout.app')

@push('styles')
    <link href="{{ getPath('home') }}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet"/>
@endpush

@section('content')
    {{--@include('home.includes.breadcrumb', ['title' => $product->name])--}}
    <section class="mt-8">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-6">
                    <div class="slider slider-for">
                        @foreach($product->getProductImages as $image)
                            <div>
                                <div class="zoom" onmousemove="zoom(event)" style="background-image: url({{ asset(getConstant('PRODUCT_IMAGE_PATH').$image->image) }})">
                                    <img src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$image->image) }}" alt="{{ $product->name }}"/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="slider slider-nav mt-4">
                        @foreach($product->getProductImages as $image)
                        <div>
                            <img src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$image->image) }}" alt="{{ $product->name }}" class="w-100 rounded"/>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-7 col-xl-6">
                    <div class="ps-lg-10 mt-6 mt-md-0">
                        <p class="mb-4 d-block">{{ $product->getCategory->name }}</p>
                        <h1 class="mb-1 mb-4">{{ $product->name }}</h1>
                        <div class="fs-4">
                            <span class="fw-bold text-dark">&#8377; {{ $product->price }}</span>
                        </div>
                        <hr class="my-6 mb-5"/>

                        <div>
                            <div class="input-group input-spinner">
                                <input type="button" value="-" class="button-minus btn btn-sm" data-field="quantity"/>
                                <input style="-moz-appearance: textfield" type="number" step="1" max="10" value="1" id="productQuantity" name="quantity"
                                       class="quantity-field form-control-sm form-input"/>
                                <input type="button" value="+" class="button-plus btn btn-sm" data-field="quantity"/>
                            </div>
                        </div>
                        <div class="mt-3 row justify-content-start g-2 align-items-center">
                            <div class="col-xxl-4 col-lg-4 col-md-5 col-5 d-grid">
                                <button data-id="{{ $product->id }}" data-name="{{ $product->name }}" type="button" class="btn btn-primary openModal">
                                    <i class="feather-icon icon-shopping-bag me-2"></i>
                                    Order Now
                                </button>
                            </div>
                        </div>
                        <hr class="my-6 mt-8"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-lg-14 mt-8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills nav-lb-tab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button
                                    class="nav-link active"
                                    id="product-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#product-tab-pane"
                                    type="button"
                                    role="tab"
                                    aria-controls="product-tab-pane"
                                    aria-selected="true">
                                Product Details
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="product-tab-pane" role="tabpanel"
                             aria-labelledby="product-tab" tabindex="0">
                            <div class="my-8">
                                <div class="mb-5">
                                    <p class="mb-0">
                                        {{ $product->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mb-lg-14 mb-8">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="mb-6 d-xl-flex text-center mt-5 justify-content-center align-items-center">
                        <!-- heading -->
                        <div class="mb-5 mb-xl-0">
                            <h2 class="mb-0">Related Products</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <!-- tab -->
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-all" role="tabpanel"
                             aria-labelledby="nav-all-tab" tabindex="0">
                            <!-- row -->
                            <div class="row row-cols-2 justify-content-center row-cols-xl-2 row-cols-md-2 g-4">
                                @foreach($product_others as $product)
                                    <div class="col">
                                        <div class="card card-product-v2 h-100">
                                            <div class="card-body position-relative">
                                                <div class="text-center position-relative">
                                                    <!-- img -->
                                                    <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><img
                                                                src="{{ getPath('upload') }}/products/{{ $product->main_image }}"
                                                                alt="{{ $product->name }}"
                                                                class="mb-3 img-fluid"/></a>
                                                </div>
                                                <!-- title -->
                                                <h2 class="fs-6"><a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                                                    class="text-inherit text-decoration-none">{{ $product->name }}</a>
                                                </h2>
                                                <!-- price -->
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div>
                                                        <span class="text-danger">&#8377; {{ $product->price }}</span>
                                                    </div>
                                                    @if($product->quantity <= 0)
                                                    <div>
                                                        <span class="text-uppercase small text-primary">Out Of Stock</span>
                                                    </div>
                                                    @else
                                                        <div>
                                                            <span class="text-uppercase small text-primary">In Stock</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- btn -->
                                                <div class="product-fade-block">
                                                    <div class="d-grid mt-4">
                                                        <a data-id="{{ $product->id }}" data-name="{{ $product->name }}" href="javascript:void(0)" class="btn btn-primary rounded-pill openModal">Order Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content-fade border-info"
                                                 style="margin-bottom: -60px"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ getPath('home') }}/libs/slick-carousel/slick/slick.min.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/slick-slider.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/zoom.js"></script>
    <script src="{{ getPath('common') }}/js/custom/custom.js"></script>
@endpush