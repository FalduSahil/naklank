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
                                    <a data-id="{{ $product->id }}" data-name="{{ $product->name }}" href="javascript:void(0)" class="btn btn-primary btn-sm openModal">
                                        Order Now
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
