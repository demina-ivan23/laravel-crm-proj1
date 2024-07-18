@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Create New Product</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                @can('view', \App\Models\Product::class)
                                    <li><a class="dropdown-item" href="{{ route('user.products.dashboard') }}">Dashboard</a>
                                    </li>
                                @endcan
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            @if ($errors->count())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-3">

                    <div class="mb-3">
                        <label for="name" class="form-label">Title</label>
                        <input class="form-control" type="text" name="title" id="title"
                            placeholder="Product's title...">
                    </div>

                    <div class="mb-3">

                        <label for="email" class="form-label">Description</label>
                        <input class="form-control" type="text" name="description" id="description"
                            placeholder="No description yet...">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input class="form-control" type="text" name="price" id="price"
                            placeholder="Product's price...">
                    </div>
                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Product Image</label>
                        <input class="form-control" type="file" name="product_image" id="product_image">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        @php
                            $categories = App\Models\ProductCategory::all();
                        @endphp
                        <div class="dropdown">
                            <select class="form-control" name="category" id="category_select"
                                @change="handleCategoryChange()">
                                <option value="{{ null }}">none</option>
                                @if ($categories->count())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->title }}">{{ $category->title }}</option>
                                    @endforeach
                                @endif
                                <option value="custom">Custom Category</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div v-if="showCustomCategoryInput">
                            <input type="text" class="form-control" id="custom_category" name="custom_category"
                                placeholder="Enter custom category">
                        </div>
                    </div>


                    <button class="btn btn-primary float-end mb-2" type="submit">
                        Create
                    </button>

                </div>

            </form>


        </div>
    </div>
@endsection
