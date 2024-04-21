@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('admin.prospects.dashboard') }}" class="btn btn-light">Go Back To Prospects</a>

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

        @if ($products->count())
            <div class="row">
                <form action="{{ route('admin.orders.store', ['prospect' => $prospect]) }}" method="POST">
                    @csrf
                    <div class="pt-4 d-flex flex-wrap justify-content-evenly">
                        @foreach ($products as $product)
                            <div class="card mb-5" style="width: 18rem;">
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
                                    <li class="list-group-item" id="card-item-1">{{ $product->price }}</li>
                                </ul>
                                <div class="card-body">

                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">Dropdown</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action before</a></li>
                                            <li><a class="dropdown-item" href="#">Another action before</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                        </ul>
                                        <input type="text" class="form-control"
                                            aria-label="Text input with 2 dropdown buttons">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">Dropdown</button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#">Separated link</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-primary float-end mb-2" type="submit">Submit Order</button>
                </form>
            </div>
        @endif
    </div>
@endsection
