<div class="card" style="width: 15rem; margin:5px">
    @if ($product->product_image)
        
    <img src="{{Storage::url($product->product_image)}}" alt="" >     
    @else
    <img src="/products/icons/box.png" alt="">
    @endif
    <div class="card-body">
      <h5 class="card-title">{{$product->title}}</h5>
      <p class="card-text">{{$product->description}}</p>
    </div>
    <ul class="list-group list-group-flush" id="card-items-container">
      <li class="list-group-item" id="card-item-1">${{$product->price}}</li>
    </ul>
    <ul class="list-group list-group-flush" id="card-items-container">
      <li class="list-group-item" id="card-item-1">Category: {{$product->category}}</li>
    </ul>
    <div class="card-body">
      <ul>
        <li>
          <a href="{{ route('admin.products.show', ['product' => $product])}}" class="dropdown-item">View</a>
        </li>
        <li>
          <a href="{{ route('admin.products.edit', ['product' => $product]) }}" class="dropdown-item">Edit </a>
        </li>
        <li>  <form action="{{ route('admin.products.destroy', ['product' => $product]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
        </form>
      </li>
    </ul>

    </div>
  </div>