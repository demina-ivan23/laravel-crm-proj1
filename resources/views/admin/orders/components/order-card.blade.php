<div class="card mb-5" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Order's Id: {{$order->id}}</h5>
      <p class="card-text">Customer's Name: {{$order->customer_name}}</p>
      <p class="card-text">Customer's Email: {{$order->customer_email}}</p>
      <p class="card-text">Products: 
        @foreach ($order->products as $product)
            {{$product->title}};   
        @endforeach
      </p>
      <p class="card-text">Order Made At: {{$order->created_at}} by GMT+0 </p>
    </div>
    <div class="card-body d-flex">
          <a href="{{ route('admin.prospects.show', ['prospect' => $order->customer])}}" class="dropdown-item justify-center">View "{{$order->customer_name}}"</a>
    </div>
  </div>