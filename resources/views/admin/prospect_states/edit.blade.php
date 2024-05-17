@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2>Edit The "{{ $prospectState->title }}" Prospect State</h2>
            </div>

            <form action="{{ route('admin.prospect_states.update', ['prospect_state' => $prospectState]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-3">
                    <div class="mb-3">
                        <label for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $prospectState->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description"
                            value="{{ $prospectState->description }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="can_transit_into[]">Can transit into</label>
                        @foreach (App\Models\ProspectState::all()->except($prospectState->id) as $otherProspectState)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $otherProspectState->id }}"
                                    name="can_transit_into[]"
                                    {{ $prospectState->states->contains($otherProspectState->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $otherProspectState->title }}
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
