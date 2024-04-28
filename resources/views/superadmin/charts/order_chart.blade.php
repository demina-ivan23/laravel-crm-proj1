
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                <h4 class="mb-3 d-flex justify-content-center">Order chart</h4>

                    <div class="col-sm-3">
                        <form action="" method="GET">
                            <h5 class="mb-3">From/To period</h5>
                            <div class="mb-2">
                                <label for="order_chart_from">From</label>
                                <input class="form-control" type="date" name="order_chart_from" id="order_chart_from">
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
                                    @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->title}}</option>
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
                            <input type="hidden" id="order_data" value="{{$jsonData}}">
                        </div>
                        <div data-v-409fe714 class="chart-view">
                            <canvas style="display: block; box-sizing: border-box; height: 228px; width: 456px;" id="orderChartCanvas">

                            </canvas>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
