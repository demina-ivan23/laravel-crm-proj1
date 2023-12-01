<div class="card mb-5" style="width: 18rem;">
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
      <li class="list-group-item" id="card-item-1">{{$product->price}}</li>
    </ul>
    <div class="card-body">
      <ul>
        <li>
          <a href="#" class="card-link">View</a>
        </li>
        <li>
          <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="card-link">Edit </a>
        </li>
        <li>  <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
        </form>
      </li>
    </ul>

    </div>
  </div>