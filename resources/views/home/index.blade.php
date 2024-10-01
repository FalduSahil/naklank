@extends('home.layout.app')

@push('styles')
    <link href="{{ getPath('home') }}/libs/tiny-slider/dist/tiny-slider.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/slick-carousel/slick/slick-theme.css" rel="stylesheet"/>
    <link href="{{ getPath('home') }}/libs/simplebar/dist/simplebar.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <section class="mt-8">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-xl-7">
                    <div class="hero-slider">
                        <div style="background: url({{ getPath('home') }}/images/slider/slider-image-1.jpg) no-repeat; background-size: cover; border-radius: 0.5rem">
                            <div class="ps-lg-12 py-lg-16 col-xxl-7 col-lg-9 py-14 px-8 text-xs-center">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="text-white">Exclusive Offer</span>
                                </div>
                                <h2 class="display-5 text-white fw-bold mb-3">Best Online Deals For Peanut Oil</h2>
                                <p class="fs-5 text-white">Only on this week... Don’t miss</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    Get Best Deal
                                    <i class="feather-icon icon-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div style="background: url({{ getPath('home') }}/images/slider/slider-image-2.jpg) no-repeat; background-size: cover; border-radius: 0.5rem">
                            <div class="ps-lg-12 py-lg-16 col-xxl-7 col-lg-9 py-14 ps-8 text-xs-center">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="text-white">Limited Time Offer</span>
                                </div>
                                <h2 class="text-white display-5 fw-bold mb-3">Fresh And Pure Peanut Oil For Everyone</h2>
                                <p class="fs-5 text-white">From your nearest local farms</p>
                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    Shop Deals Now
                                    <i class="feather-icon icon-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div style="background: url({{ getPath('home') }}/images/slider/slider-image-3.jpg) no-repeat; background-size: cover; border-radius: 0.5rem">
                            <div class="ps-lg-12 py-lg-16 col-xxl-7 col-lg-9 py-14 ps-8 text-xs-center">
                                <div class="d-flex align-items-center mb-4">
                                    <span class="text-white">Purchase Now</span>
                                </div>
                                <h2 class="text-white display-5 fw-bold mb-3">Extraordinary Peanuts For Extraordinary People</h2>
                                <p class="fs-5 text-white">The taste of uniqueness in every drop</p>

                                <a href="{{ route('products') }}" class="btn btn-primary">
                                    Shop This Week Offer
                                    <i class="feather-icon icon-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-5 col-12 d-lg-flex d-xl-block gap-3 gap-xl-0">
                    <div class="flex-fill px-8 py-9 mb-6 rounded"
                         style="background: url({{ getPath('home') }}/images/banner/ad-banner-1.jpg) no-repeat; background-size: cover">
                        <div>
                            <h3 class="mb-0 text-black fw-bold">
                                Discover a new world of peanuts:
                                <br/>
                                Uniqueness guaranteed
                            </h3>
                            <div class="mt-4 text-black mb-5 fs-5">
                                <p class="mb-0">The taste of uniqueness</p>
                            </div>
                            <a href="{{ route('products') }}" class="btn btn-dark">Shop Now</a>
                        </div>
                    </div>

                    <div class="flex-fill px-8 py-8 rounded"
                         style="background: url({{ getPath('home') }}/images/banner/ad-banner-2.jpg) no-repeat; background-size: cover">
                        <div>
                            <!-- Banner Content -->
                            <h3 class="fw-bold mb-3">
                                Peanuts fit for royalty:
                                <br/>
                                Taste the class
                            </h3>
                            <div class="mt-4 text-dark mb-5 fs-5">
                                <p class="fs-5 mb-0">
                                    Go beyond ordinary
                                    <br/>
                                    Peanuts with a twist
                                </p>
                            </div>

                            <a href="{{ route('products') }}" class="btn btn-dark">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="my-lg-14 my-8">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-6">
                        <!-- heading-->
                        <h3 class="mb-0">Shop Popular Categories</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-2 col-md-4 col-6">
                            <div class="text-center mb-10">
                                <a href="{{ route('categories', ['slug' => $category->slug]) }}"><img height="115" width="115"
                                                 src="{{ getPath('upload') }}/categories/{{ $category->image }}"
                                                 alt="{{ $category->name }}" class="card-image rounded-circle"/></a>
                                <div class="mt-4">
                                    <h5 class="fs-6 mb-0"><a href="{{ route('categories', ['slug' => $category->slug]) }}" class="text-inherit">{{ $category->name }}</a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mb-lg-14 mb-8">
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-12">
                    <div class="mb-6 d-xl-flex justify-content-between align-items-center">
                        <!-- heading -->
                        <div class="mb-5 mb-xl-0">
                            <h3 class="mb-0">New Products</h3>
                            <p class="mb-0">New products with updated stocks</p>
                        </div>
                        <div>
                            <!-- nav -->
                            <nav>
                                <ul class="nav nav-pills nav-scroll border-bottom-0 gap-1" id="nav-tab" role="tablist">
                                    <!-- nav item -->
                                    <li class="nav-item">
                                        <!-- nav link -->
                                        <a
                                                href="index-3.html#"
                                                class="nav-link active"
                                                id="nav-all-tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#nav-all"
                                                role="tab"
                                                aria-controls="nav-all"
                                                aria-selected="true">
                                            All Products
                                        </a>
                                    </li>
                                    <!-- nav item -->
                                    @php($i = 0)
                                    @foreach($categories as $category)
                                        @if($i < 5 && $category)
                                            <li class="nav-item">
                                                <a
                                                        href="#"
                                                        class="nav-link"
                                                        id="nav-{{ $category->id }}-tab"
                                                        data-bs-toggle="tab"
                                                        data-bs-target="#nav-{{ $category->id }}"
                                                        role="tab"
                                                        aria-controls="nav-{{ $category->id }}"
                                                        aria-selected="false">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                            @php($i++)
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
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
                            <div class="row row-cols-2 row-cols-xl-5 row-cols-md-3 g-4">
                                @foreach($products as $product)
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
                                                    <div><span class="text-uppercase small text-primary">In Stock</span>
                                                    </div>
                                                </div>
                                                <!-- btn -->
                                                <div class="product-fade-block">
                                                    <div class="d-grid mt-4">
                                                        <a href="#" class="btn btn-primary rounded-pill">Add to Cart</a>
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
                        @php($i = 0)
                        @foreach($products as $product)
                            @if($i < 5 && $product->getCategory)
                                <div class="tab-pane fade" id="nav-{{ $product->getCategory->id }}" role="tabpanel"
                                     aria-labelledby="nav-{{ $product->getCategory->id }}-tab">
                                    <div class="row row-cols-2 row-cols-xl-5 row-cols-md-3 g-4">
                                        @foreach($products->where('category_id', $product->getCategory->id) as $categoryProduct)
                                            <div class="col">
                                                <div class="card card-product-v2 h-100">
                                                    <div class="card-body position-relative">
                                                        <div class="text-center position-relative">
                                                            <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><img
                                                                        src="{{ getPath('upload') }}/products/{{ $categoryProduct->main_image }}"
                                                                        alt="{{ $categoryProduct->name }}"
                                                                        class="mb-3 img-fluid"/></a>
                                                        </div>
                                                        <!-- title -->
                                                        <h2 class="fs-6"><a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                                                            class="text-inherit text-decoration-none">{{ $categoryProduct->name }}</a>
                                                        </h2>
                                                        <!-- price -->
                                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                            <div>
                                                                <span class="text-danger">&#8377; {{ $categoryProduct->price }}</span>
                                                            </div>
                                                            <div><span class="text-uppercase small text-primary">In Stock</span>
                                                            </div>
                                                        </div>
                                                        <!-- btn -->
                                                        <div class="product-fade-block">
                                                            <div class="d-grid mt-4">
                                                                <a href="#" class="btn btn-primary rounded-pill">Add to
                                                                    Cart</a>
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
                                @php($i++)
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ getPath('home') }}/libs/slick-carousel/slick/slick.min.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/slick-slider.js"></script>
    <script src="{{ getPath('home') }}/libs/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="{{ getPath('home') }}/js/vendors/tns-slider.js"></script>
@endpush