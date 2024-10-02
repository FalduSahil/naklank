@extends('home.layout.app')

@push('styles')
    <link href="{{ getPath('home') }}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet"/>
@endpush

@section('content')
    @include('home.includes.breadcrumb', ['title' => $product->name])
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
                                <input style="-moz-appearance: textfield" type="number" step="1" max="10" value="1" name="quantity"
                                       class="quantity-field form-control-sm form-input"/>
                                <input type="button" value="+" class="button-plus btn btn-sm" data-field="quantity"/>
                            </div>
                        </div>
                        <div class="mt-3 row justify-content-start g-2 align-items-center">
                            <div class="col-xxl-4 col-lg-4 col-md-5 col-5 d-grid">
                                <button type="button" class="btn btn-primary">
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
@endsection

@push('scripts')
    <script src="{{ getPath('home') }}/libs/slick-carousel/slick/slick.min.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/slick-slider.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/zoom.js"></script>
    <script src="{{ getPath('common') }}/js/custom/custom.js"></script>
@endpush