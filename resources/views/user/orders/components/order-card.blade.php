<div class="card mb-5" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">Order's Id: {{ $order->id }}</h5>
        <p class="card-text">Customer's Name: {{ $order->customer->name }}</p>
        <p class="card-text">Customer's Email: {{ $order->customer->email }}</p>
        <p class="card-text">Products:
            @foreach ($order->products as $product)
                {{ $product->title }};
            @endforeach
        </p>
        <p class="card-text">Order's current status: {{ $order->statuses()->latest()->first()->title}}</p>
        <p class="card-text">Order created at: {{ $order->created_at }} by GMT+0</p>
        @if ($order->statuses()->latest()->first()->is_final)
            <p class="card-text">Order closed at: {{ $order->statuses()->latest()->first()->created_at }} by GMT+0</p>
        @endif
    </div>
    <div class="card-body d-flex">
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Actions
            </button>
            <ul class="dropdown-menu">
                <a href="{{ route('user.prospects.show', ['prospect' => $order->customer]) }}"
                    class="dropdown-item justify-center">View "{{ $order->customer->name }}"</a>
                <a href="{{ route('user.orders.show', ['order' => $order]) }}"
                    class="dropdown-item justify-center">View
                    this order</a>
                <a href="{{ route('user.orders.edit', ['order' => $order]) }}"
                    class="dropdown-item justify-center">Edit
                    this order</a>
            </ul>
        </div>
    </div>
</div>
