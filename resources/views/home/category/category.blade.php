@extends('home.layout.app')

@section('content')
    @include('home.includes.breadcrumb', ['title' => $category->name])
    <section class="mt-8 mb-lg-14 mb-8">
        <div class="container">

            <div class="row">

                <div class="col-lg-12">

                    <div class="card mb-4 bg-light border-0">

                        <div class="card-body p-9">

                            <h2 class="mb-0 fs-1">{{ $category->name }}</h2>
                        </div>
                    </div>

                    <div class="d-lg-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-3 mb-md-0">
                                <span class="text-dark">{{ $products->total() }}</span>
                                {{ $products->total() > 1 ? 'Products' : 'Product' }} Found
                            </p>
                        </div>

                        <div class="d-md-flex justify-content-between align-items-center">
                            <div class="d-flex mt-2 mt-lg-0">
                                <div>
                                    <select class="form-select">
                                        <option selected>Sort by: Featured</option>
                                        <option value="Low to High">Price: Low to High</option>
                                        <option value="High to Low">Price: High to Low</option>
                                        <option value="Release Date">Release Date</option>
                                        <option value="Avg. Rating">Avg. Rating</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 row-cols-lg-5 row-cols-2 row-cols-md-3 mt-2">
                        @foreach($products as $product)
                            <div class="col">

                            <div class="card card-product">
                                <div class="card-body">
                                    <div class="text-center position-relative">
                                        <a href="{{ route('getProduct', ['slug' => $product->slug]) }}">
                                            <img src="{{ getPath('upload') }}/products/{{ $product->main_image }}" alt="{{ $product->name }}" class="mb-3 img-fluid"/>
                                        </a>
                                    </div>

                                    <div class="text-small mb-1">
                                        <p class="text-decoration-none text-muted"><small>{{ $category->name }}</small></p>
                                    </div>
                                    <h2 class="fs-6"><a href="{{ route('getProduct', ['slug' => $product->slug]) }}" class="text-inherit text-decoration-none">{{ $product->name }}</a></h2>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div><span class="text-dark">&#8377; {{ $product->price }}</span></div>

                                        <div>
                                            <a href="#" class="btn btn-primary btn-sm">
                                                <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="16"
                                                        height="16"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg>
                                                Add
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row mt-8">
                        <div class="col">
                            <nav>
                                {{ $products->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection