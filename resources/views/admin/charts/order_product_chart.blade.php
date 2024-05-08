
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                <h4 class="mb-3 d-flex justify-content-center">Product-related chart</h4>

                    <div class="col-sm-3">
                        <form action="" method="GET">
                            <h5 class="mb-3">From/To period</h5>
                            <div class="mb-2">
                                <label for="order_product_chart_from">From</label>
                                <input class="form-control" type="date" name="order_product_chart_from" id="order_product_chart_from">
                            </div>

                            <div class="mb-4">
                                <label for="order_product_chart_to">To</label>
                                <input class="form-control" type="date" name="order_product_chart_to" id="order_product_chart_to">
                            </div>
                            <div class="mb-2">
                                <label for="product_category">Product Category</label>
                                <select class="form-control" name="product_category" id="product_category">
                                    @php
                                        use App\Models\ProductCategory;
                                        $categories = ProductCategory::all();
                                    @endphp
                                    <option value="all">All</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                    <option value="{{null}}">Without a category</option>
                                </select>
                            </div>
                            <button class="btn btn-primary pt-0 pb-0" type="submit">Submit</button>
                        </form>
                    </div>
                    <div class="col-sm-9">
                        <div id="order_product_data_wrapper" hidden>
                            @php
                                $jsonData = json_encode($data['order_product_chart_info']);
                            @endphp
                            <input type="hidden" id="order_product_data" value="{{$jsonData}}">
                        </div>
                        <div data-v-409fe714 class="chart-view">
                            <canvas style="display: block; box-sizing: border-box; height: 228px; width: 456px;" id="productOrderChartCanvas">

                            </canvas>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
