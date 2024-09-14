@switch($for)

    @case('modal')
        <div class="quick-view-content single-product-page-content">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="product-thumbnail-wrap">
                        <div class="product-thumb-carousel owl-carousel">
                            @foreach($product->getProductImages as $image)
                                <div class="single-thumb-item">
                                    <a href="javascript:void(0)"><img class="img-fluid" src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$image->image) }}" alt="Product"/></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6 mt-5 mt-md-0">
                    <div class="product-details">
                        <h2><a href="javascript:void(0)">{{ $product->name }}</a></h2>

                        @auth
                            @php
                                $price = $product->price / $product->per_box_quantity;
                            @endphp
                            <p class="product-sku-status"><strong>Per Piece Price :</strong> &#8377; {{ $price }}</p>

                            <p class="product-sku-status"><strong>Per Box Price :</strong> &#8377; {{ $product->price }}</p>

                            <p class="product-sku-status"><strong>Per Box :</strong> {{ $product->per_box_quantity != '' ? $product->per_box_quantity . ' Pieces' : '-' }}</p>

                        @endauth

                        <p class="product-sku-status"><strong>Product Description :</strong> {{ strlen($product->description) > 150 ? substr($product->description, 0, 150).'...' : $product->description }}</p>


                        <div class="mb-5 mt-5 d-none d-sm-block">
                            <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                               class="btn btn-add-to-cart">View Product</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @break

    @case('sort')
        @if(!$products->isEmpty())
            <div class="products-wrapper">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single-product-item text-center">
                                <figure class="product-thumb">
                                    <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><img
                                            src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}"
                                            alt="Products"
                                            class="img-fluid"></a>
                                </figure>

                                <div class="product-details">
                                    <h2>
                                        <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><strong>{{ $product->name  }}</strong></a>
                                    </h2>
                                    @auth
                                        @php
                                            $price = $product->price / $product->per_box_quantity;
                                        @endphp
                                        <span class="price">Per Piece Price: <strong> &#8377; {{ $price }}</strong></span>
                                    @endauth
                                    <p class="products-desc">{{ $product->description }}</p>
                                    <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                       class="btn btn-add-to-cart">View Product</a>
                                </div>

                                <div id="quick-view-data" data-route="{{ route('quickView') }}" class="product-meta">
                                    <button onclick="openQuickView('{{ $product->id }}')" type="button">
                                        <span data-toggle="tooltip" data-placement="left" title="Quick View"><i
                                                class="fa fa-compress"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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

    @case('sort-by-label')

        @if(!$products->isEmpty())
            <div class="products-wrapper">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-4 col-sm-6">
                            <div class="single-product-item text-center">
                                <figure class="product-thumb">
                                    <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><img
                                            src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}"
                                            alt="Products"
                                            class="img-fluid"></a>
                                </figure>

                                <div class="product-details">
                                    <h2>
                                        <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"><strong>{{ $product->name  }}</strong></a>
                                    </h2>
                                    @auth
                                        @php
                                            $price = $product->price / $product->per_box_quantity;
                                        @endphp
                                        <span class="price">Per Piece Price: <strong>&#8377; {{ $price }}</strong></span>
                                    @endauth
                                    <p class="products-desc">{{ $product->description }}</p>
                                    <a href="{{ route('getProduct', ['slug' => $product->slug]) }}"
                                       class="btn btn-add-to-cart">View Product</a>
                                </div>

                                <div id="quick-view-data" data-route="{{ route('quickView') }}" class="product-meta">
                                    <button onclick="openQuickView('{{ $product->id }}')" type="button">
                                        <span data-toggle="tooltip" data-placement="left" title="Quick View"><i
                                                class="fa fa-compress"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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

    @case('cart')
        @if($cart != null)
            @if($cart->cartItems->isEmpty())
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-center">No Products In Cart</h3>
                        </div>
                    </div>
                </div>
            @else
                @foreach($cart->cartItems as $cart_item)
                    <div class="single-cart-item d-flex">
                        <figure class="product-thumb">
                            <a href="#"><img class="img-fluid"
                                             src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$cart_item->product->main_image) }}"
                                             alt="Products"/></a>
                        </figure>

                        <div class="product-details">
                            <h2>
                                <a href="{{ route('getProduct', ['slug' => $cart_item->product->slug]) }}">{{ $cart_item->product->name }}</a>
                            </h2>
                            <div class="cal d-flex align-items-center">
                                <span class="quantity">{{ $cart_item->quantity }}</span>
                                <span class="multiplication">X</span>
                                <span
                                    class="price">&#8377; {{ number_format($cart_item->quantity * $cart_item->product->price, 0, '.', ',') }}</span>
                            </div>
                        </div>
                        <a id="deleteCart" data-route="{{ route('removeFromCart') }}"
                           onclick="removeFromCart('{{ $cart_item->id }}')" href="javascript:void(0)"
                           class="remove-icon remove-from-cart"><i class="fa fa-trash-o"></i></a>
                    </div>
                @endforeach
            @endif
        @else
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">No Products In Cart</h3>
                    </div>
                </div>
            </div>
        @endif
        @break

    @case('labels')
        @foreach(getLabels($category_id) as $label)
            <option value="{{ $label->id }}">{{ $label->name }}</option>
        @endforeach
        @break

    @case('addProduct')
        @foreach($products as $product)
            <tr class="product-row" data-product-id="{{ $product->id }}">
                <td>
                    {{ $product->name }}
                </td>
                <td>
                    <img class="rounded" height="70" width="70"
                         src="{{ asset(getConstant('PRODUCT_IMAGE_PATH').$product->main_image) }}" alt="">
                </td>
                <td class="price">{{ '₹'.formatNumber($product->price) }}</td>
                <td style="width: 160px" class="text-center form-group">
                    <input type="number" class="form-control quantity-input" min="1" value="1">
                </td>
                <td class="text-center subtotal">{{ '₹'.formatNumber($product->price * 1) }}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-danger delete-product"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        @endforeach

    @default
        <span></span>

@endswitch
