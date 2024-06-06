@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('dashboards.prospects-products-orders') }}" class="btn btn-light">Go Back To Prospects</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Create New Prospect</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                @can('view', \App\Models\Prospect::class)
                                <li><a class="dropdown-item" href="{{ route('dashboards.prospects-products-orders') }}">Dashboard</a>
                                </li>
                                @endcan
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            @if ($errors->count())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.prospects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-3">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                            placeholder="Prospect's name..." required>
                    </div>

                    <div class="mb-3">

                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                            placeholder="Prospect's phone number...">
                    </div>

                    <div class="mb-3">
                        <label for="facebook_account" class="form-label">Facebook account</label>
                        <input class="form-control" type="text" name="facebook_account" id="facebook_account"
                            placeholder="Prospect's Facebook account...">
                    </div>

                    <div class="mb-3">
                        <label for="instagram_account" class="form-label">Instagram account</label>
                        <input class="form-control" type="text" name="instagram_account" id="instagram_account"
                            placeholder="Prospect's Instagram account...">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Prospect's address...">
                    </div>

                    <div class="mb-3">
                        <label for="personal_info" class="form-label">Personal info</label>
                        <input class="form-control" type="text" name="personal_info" id="personal_info"
                            placeholder="Some additional info...">
                    </div>
                    <div class="mb-3">
                        <label for="prospect_state" class="form-label">Prospect state</label>
                        <div class="dropdown">
                            <select class="form-control" name="prospect_state" id="prospect_state_select"
                                @change="handleProspectStateChange()">
                                @foreach (App\Models\ProspectState::all() as $prospectState)
                                    <option value="{{ $prospectState->id }}">{{ $prospectState->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="prospect_state_explanation">Why this state?</label>
                        <input class="form-control" type="text" name="prospect_state_explanation" placeholder="Your explanation here...">
                    </div>

                    <button class="btn btn-primary float-end mb-2" type="submit">
                        Create
                    </button>

                </div>
            </form>


        </div>
    </div>
@endsection
