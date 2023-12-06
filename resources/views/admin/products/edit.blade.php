@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('admin.products.dashboard')}}" class="btn btn-light">Go Back To Products</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Edit The "{{$product->title}}" Product</h2>
                    
                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.products.dashboard')}}">Dashboard</a></li>
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
            
            <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
<div class="p-3">

    <div class="mb-3">
        <label for="name" class="form-label">Title</label>
        <input class="form-control" type="text" name="title" id="title" placeholder="Product's title..." value="{{$product->title}}">
    </div>
    
    <div class="mb-3">
        
        <label for="email" class="form-label">Description</label>
        <input class="form-control" type="text" name="description" id="description" placeholder="No description yet..." value="{{$product->description}}">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Price</label>
        <input class="form-control" type="text" name="price" id="price" placeholder="Product's price..." value="{{$product->price}}">
    </div>
    <div class="mb-3">
        <label for="profileImage" class="form-label">Product Image</label>
        <input  class="form-control" type="file" name="product_image" id="product_image">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input class="form-control" type="text" name="category" id="category" placeholder="Product's category...">
    </div>

        <button class="btn btn-primary float-end mb-2" type="submit">
            Submit
        </button>

    </div>
</div>

</div>
</form>


</div>
</div>
@endsection