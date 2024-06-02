@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h2 class="d-flex justify-content-center mb-5">Charts Dashboard</h2>

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('orderChart', 'orderChartTabToggle')" id="orderChartTabToggle">
                        <h5>
                            Order Chart
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('productChart', 'productChartTabToggle')" id="productChartTabToggle">
                        <h5>
                            Product Chart
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('prospectChart', 'prospectChartTabToggle')" id="prospectChartTabToggle">
                        <h5>
                            Prospect Chart
                        </h5>
                    </button>
                </li>
            </ul>
        </div>

        <div class="hidden tablink" id="orderChart">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <h4 class="mb-3 d-flex justify-content-center">Order chart</h4>

                        <div class="col-sm-3">
                            <form action="" method="GET">
                                <h5 class="mb-3">From/To period</h5>
                                <div class="mb-2">
                                    <label for="order_chart_from">From</label>
                                    <input class="form-control" type="date" name="order_chart_from"
                                        id="order_chart_from">
                                </div>

                                <div class="mb-4">
                                    <label for="order_chart_to">To</label>
                                    <input class="form-control" type="date" name="order_chart_to" id="order_chart_to">
                                </div>
                                <div class="mb-4">
                                    <label for="order_status" class="form-label">Order status</label>
                                    <select class="form-control" name="order_status" id="order_status">
                                        <option value="all">All</option>
                                        @php
                                            use App\Models\OrderStatus;
                                            $statuses = OrderStatus::all();
                                        @endphp
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-primary pt-0 pb-0" type="submit">Submit</button>
                            </form>
                        </div>

                        <div class="col-sm-9">
                            <div id="order_data_wrapper" hidden>
                                @php
                                    $jsonData = json_encode($data['order_chart_info']);
                                @endphp
                                <input type="hidden" id="order_data" value="{{ $jsonData }}">
                            </div>
                            <div class="chart-view">
                                <canvas style="display: block; box-sizing: border-box; height: 228px; width: 456px;"
                                    id="orderChartCanvas">

                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden tablink" id="productChart">
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
        <div class="hidden tablink" id="prospectChart">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <h5 class="mb-3 d-flex justify-content-center">Prospect-related chart</h5>
    
                        <div class="col-sm-3">
                            <form action="" method="GET">
                                <h5 class="mb-3">From/To period</h5>
                                <div class="mb-2">
                                    <label for="order_prospect_chart_from">From</label>
                                    <input class="form-control" type="date" name="order_prospect_chart_from"
                                        id="order_prospect_chart_from">
                                </div>
    
                                <div class="mb-4">
                                    <label for="order_prospect_chart_to">To</label>
                                    <input class="form-control" type="date" name="order_prospect_chart_to"
                                        id="order_prospect_chart_to">
                                </div>
                                <div class="mb-2">
                                    <label for="prospect_state">Prospect State</label>
                                    <select class="form-control" name="prospect_state" id="prospect_state">
                                        @php
                                            use App\Models\ProspectState;
                                            $prospect_states = ProspectState::all();
                                        @endphp
                                        <option value="all">All</option>
                                        @foreach ($prospect_states as $prospect_state)
                                            <option value="{{ $prospect_state->id }}">{{ $prospect_state->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <button class="btn btn-primary pt-0 pb-0" type="submit">Submit</button>
                            </form>
                        </div>
                        <div class="col-sm-9">
                            <div id="order_prospect_data_wrapper" hidden>
                                @php
                                    $jsonData = json_encode($data['order_prospect_chart_info']);
                                @endphp
                                <input type="hidden" id="order_prospect_data" value="{{ $jsonData }}">
                            </div>
                            <div data-v-409fe714 class="chart-view">
                                <canvas style="display: block; box-sizing: border-box; height: 228px; width: 456px;"
                                    id="prospectOrderChartCanvas">
    
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
