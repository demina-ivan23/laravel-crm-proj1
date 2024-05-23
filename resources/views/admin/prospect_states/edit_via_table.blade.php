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
        <div class="card mt-4" style="min-width:40em">
            <div class="card-body d-flex justify-content-center">
                <h2 class="float-center">Edit Prospect States Via Table</h2>
            </div>
            <form action="{{ route('admin.prospect_states.update_via_table') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="table-responsive">
                    <table class="table" style="min-width:60em">
                        <thead>
                            <tr>
                                <th scope="col">
                                    Status \ Can Transit Into
                                </th>
                                @foreach (\App\Models\ProspectState::all() as $prospectState)
                                    <th scope="col">
                                        {{ $prospectState->title }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Models\ProspectState::all() as $prospectState)
                                <tr>
                                    <th scope="row">
                                        {{ $prospectState->title }}
                                    </th>

                                    @foreach (\App\Models\ProspectState::all() as $anotherProspectState)
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $anotherProspectState->id }}"
                                                    name="{{ $prospectState->id }}-can_transit_into[]"
                                                    {{ $prospectState->states->contains($anotherProspectState->id) ? 'checked' : '' }}>
                                            </div>
                                        </th>
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
