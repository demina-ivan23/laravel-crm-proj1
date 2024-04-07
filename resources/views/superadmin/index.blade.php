@extends('layouts.app')

@section('content')

<div class="container">
<div class="card mt-4">
    <div class="card-body">
<div class="d-flex">

    <form action="" method="GET">
        <input type="date" name="from">
        <input type="date" name="to">
        <select name="current_state_filter" id="">
            @php 
            use App\Models\ProspectState;
            $prospect_states = ProspectState::all();
            @endphp
                @foreach($prospect_states as $prospect_state)
                <option value="{{$prospect_state->id}}">{{$prospect_state->title}}</option>
                @endforeach
            </select>
            <select name="product_filter" id="">
                @php
                use App\Models\Product;
                $products = Product::all();
                @endphp
                @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->title}}</option>
                @endforeach
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>
    </div>
    </div>
</div>

@endsection

