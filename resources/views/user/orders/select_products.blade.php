@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('user.prospects.dashboard') }}" class="btn btn-light">Go Back To Prospects</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">
                    <h2>Products To Order <small class="text-muted">Choose Products To Order</small></h2>
                    <div class="ml-auto" style="margin-left: auto">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                    <div class="row" style="margin-top:60px; margin-right:5px">
                        <div class="col-sm-12">
                            <h4 class="ml-5 mb-10">Filters:</h4>
                        </div>
                        <div class="ml-10 mb-10" id="price-filters">
                            <div class="col-sm-12">
                                <h5>Price filters:</h5>
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="<10"> Price is
                                    less than $10
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="price_filter" class="filter-checkbox" value="10-100"> Price is
                                    $10 to $100
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="price_filter" class="filter-checkbox" value="100-500"> Price is
                                $100 to $500
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="500-1000"> Price
                                is $500 to $1000
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="1000-5000"> Price
                                is $1000 to $5000
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value=">5000"> Price is
                                higher than $5000
                            </div>
                        </div>
                        <div class="ml-10 mb-10" id="category-filters">
                            <div class="col-sm-12">
                                <h5>Category filters:</h5>
                            </div>
                            @php
                                use App\Services\ProductService;
                                $categories = ProductService::getAllCategories();
                                @endphp
                            @foreach ($categories as $category)
                            <div class="col-sm-12">
                                <input type="checkbox" name="category_filter" value="{{ $category->id }}"
                                class="filter-checkbox"> {{ $category->title }}
                            </div>
                            @endforeach
                            <div class="col-sm-12">
                                <input type="checkbox" name="category_filter" value="none" class="filter-checkbox"> No
                                category
                            </div>
                        </div>
                    </div>
                </div>
                @if ($products->count())
                <div class="col-sm-9">
                    
                    <form action="{{ route('user.orders.create', ['prospect' => $prospect]) }}" method="GET" id="select_products_form">
                        @csrf
                        <div class="pt-4 d-flex flex-wrap justify-content-evenly">
                            @foreach ($products as $product)
                                <div class="card mb-5" style="width: 18rem;" id="product_{{ $product->id }}"
                                    style="outline: none">
                                    @if ($product->product_image)
                                        <img src="{{ Storage::url($product->product_image) }}" alt="">
                                    @else
                                        <img src="/products/icons/box.png" alt="">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
                                    </div>
                                    <ul class="list-group list-group-flush" id="card-items-container">
                                        <li class="list-group-item" id="card-item-1">${{ $product->price }}</li>
                                    </ul>
                                    <div class="card-body">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary"
                                                id="decrement_product_count_{{ $product->id }}" type="button"
                                                @click="incrementDecrementProductCount('{{ $product->id }}', 'decrement')">-</button>
                                            <input type="number"  class="form-control"
                                                id="product_count_{{ $product->id }}" value="0" min="0"
                                                oninput="validity.valid||(value=Math.round(value));">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="increment_product_count_{{ $product->id }}"
                                                @click="incrementDecrementProductCount('{{ $product->id }}', 'increment')">+</button>

                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-6">
                                {{ $products->appends(request()->except('page'))->links() }}
                            </div>
                            <input type="hidden" name="selected_products_json" id="selected_products_json">
                            <button class="btn btn-primary float-end mb-2" type="button" @click="handleProductsArrayTransmission()">Submit Selection</button>
                        </form>
                    </div>
                    @endif
            </div>
    </div>
@endsection
