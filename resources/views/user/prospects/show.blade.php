@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>View The Prospect "{{ $prospect->name }}"</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                @can('view', $prospect)
                                    <li><a class="dropdown-item" href="{{ route('dashboards.prospects-products-orders') }}">Dashboard</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('user.prospects.edit', ['prospect' => $prospect]) }}">Edit</a>
                                    </li>
                                @endcan
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
                <div class="p-3">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name"
                            placeholder="Prospect's name..." value="{{ $prospect->name }}" disabled>
                    </div>

                    <div class="mb-3">

                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" id="email"
                            value="{{ $prospect->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone number</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                            placeholder="Prospect's phone number..." value="{{ $prospect->phone_number }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="facebook_account" class="form-label">Facebook account</label>
                        <input class="form-control" type="text" name="facebook_account" id="facebook_account"
                            placeholder="Prospect's Facebook account..." value="{{ $prospect->facebook_account }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="instagram_account" class="form-label">Instagram account</label>
                        <input class="form-control" type="text" name="instagram_account" id="instagram_account"
                            placeholder="Prospect's Instagram account..." value="{{ $prospect->instagram_account }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                            placeholder="Prospect's address..." value="{{ $prospect->address }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="personal_info" class="form-label">Personal info</label>
                        <input class="form-control" type="text" name="personal_info" id="personal_info"
                            placeholder="Some additional info..." value="{{ $prospect->personal_info }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="prospect_state" class="form-label">Prospect state</label>
                        <div class="dropdown">
                            <select class="form-control" name="prospect_state" id="prospect_state_select" disabled>
                                @foreach (App\Models\ProspectState::all() as $prospectState)
                                    @if ($prospect->latestState->states->contains($prospectState->id) || $prospect->latestState->id === $prospectState->id)
                                        <option value="{{ $prospectState->id }}">{{ $prospectState->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="prospect_state_explanation">Why this state?</label>
                        <input class="form-control" type="text" name="prospect_state_explanation"
                            placeholder="Your explanation here..."
                            value="{{ $prospect->latestState->pivot->explanation }}" disabled>
                    </div>
                </div>
        </div>
    </div>
@endsection
