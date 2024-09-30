@switch($for)

    @case('sort-products')
        @if(!$products->isEmpty())
            @foreach($products as $product)
                <div class="col">

                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="{{ route('getProduct', ['slug' => $product->slug]) }}">
                                    <img src="{{ getPath('upload') }}/products/{{ $product->main_image }}"
                                         alt="{{ $product->name }}" class="mb-3 img-fluid"/>
                                </a>
                            </div>
                            <h2 class="fs-6"><a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                                class="text-inherit text-decoration-none">{{ $product->name }}</a>
                            </h2>

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
        @else
            <div class="products-wrapper">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center">No Product Available</h2>
                    </div>
                </div>
            </div>
        @endif
        @break

        @case('sort-categories')
        @if(!$products->isEmpty())
            @foreach($products as $product)
                <div class="col">

                    <div class="card card-product">
                        <div class="card-body">
                            <div class="text-center position-relative">
                                <a href="{{ route('getProduct', ['slug' => $product->slug]) }}">
                                    <img src="{{ getPath('upload') }}/products/{{ $product->main_image }}"
                                         alt="{{ $product->name }}" class="mb-3 img-fluid"/>
                                </a>
                            </div>
                            <h2 class="fs-6"><a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                                class="text-inherit text-decoration-none">{{ $product->name }}</a>
                            </h2>

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
        @else
            <div class="products-wrapper">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center">No Product Available</h2>
                    </div>
                </div>
            </div>
        @endif
        @break

    @default
        <span></span>

@endswitch
