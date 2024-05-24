@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex">

                <h2>Create New Prospect State</h2>

                <div class="ml-auto" style="margin-left: auto">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.prospect_states.index') }}">All Prospect
                                    States</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <form action="{{route('user.prospect_states.store')}}" method="POST">
            @csrf
            <div class="p-3">
                <div class="mb-3">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" id="title">
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <input class="form-control" type="text" name="description" id="description">
                </div>
                <div class="mb-3">
                    <label for="">Can transit into</label>
                        @foreach (App\Models\ProspectState::all() as $prospectState)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$prospectState->id}}" name="can_transit_into[]">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{$prospectState->title}}
                            </label>
                        </div>
                        @endforeach
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <input class="btn btn-primary" type="submit" value="Submit">
                </div>
            </div>
            </form>
        </div>
</div>

@endsection