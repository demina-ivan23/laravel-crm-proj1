@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="float-center">Edit Order Statuses Via Table</h2>
            </div>
            <div class="p-3 m-4">


                    <table class="w-full text-sm text-left">
                        <thead class="mb-5">
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
                                <tr class="mb-5">
                                    <th scope="row">
                                        {{ $orderStatus->title . ' ' }} {{$orderStatus->is_final ? '(final)' : ''}} 
                                    </th>
                                    @if (!$orderStatus->is_final)
                                        
                                    @foreach (\App\Models\OrderStatus::all() as $anotherOrderStatus)
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                            value="{{ $anotherOrderStatus->id }}" name="{{$orderStatus->id}}-can_transit_into[]"
                                            {{ $orderStatus->statuses->contains($anotherOrderStatus->id) ? 'checked' : '' }}>
                                        </div>
                                    </th>
                                    @endforeach
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

            </div>
        </div>
    </div>
@endsection
