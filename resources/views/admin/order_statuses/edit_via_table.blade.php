@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4" style="min-width:40em">
        <div class="card-body d-flex justify-content-center">
            <h2 class="float-center">Edit Order Statuses Via Table</h2>
        </div>    
        <form action="{{route('admin.order_statuses.update_via_table')}}" method="POST">
            @csrf
            @method('PUT')
            <div class="table-responsive">
                    <table class="table" style="min-width:60em">
                        <thead>
                            <tr>
                                <th scope="col">
                                    Status \ Can Transit Into
                                </th>
                                @foreach (\App\Models\OrderStatus::all() as $orderStatus)
                                <th scope="col">
                                    {{ $orderStatus->title }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\OrderStatus::all() as $orderStatus)
                            <tr>
                                <th scope="row">
                                    {{ $orderStatus->title . ' ' }} {{$orderStatus->is_final ? '(final)' : ''}} 
                            </th>
                            
                            @foreach (\App\Models\OrderStatus::all() as $anotherOrderStatus)
                            @if (!$orderStatus->is_final)
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                    value="{{ $anotherOrderStatus->id }}" name="{{$orderStatus->id}}-can_transit_into[]"
                                    {{ $orderStatus->statuses->contains($anotherOrderStatus->id) ? 'checked' : '' }}>
                                </div>
                            </th>
                            @else
                            <th>
                                </th>
                                @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="submit" value="Apply changes" class="btn btn-primary m-3 float-end">
            </form>
            </div>                    
        </div>
        @endsection
        