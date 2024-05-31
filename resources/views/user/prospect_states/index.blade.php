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
        <h4 class="d-flex justify-content-center">States Dashboard</h4>
        @if ($prospectStates->count())
            <table class="table mt-4">
                <thead>
                    <th>
                        <h4>
                            <strong>
                                Title
                            </strong>
                        </h4>
                    </th>
                    <th>
                        <h4>
                            <strong>
                                Description
                            </strong>
                        </h4>
                    </th>
                    <th>
                        <h4>
                            <strong>
                                Transits to
                            </strong>
                        </h4>
                    </th>
                    <th>
                        <h4>
                            <strong>
                                Actions
                            </strong>
                        </h4>
                    </th>
                </thead>
                <tbody>
                    @foreach ($prospectStates as $prospectState)
                        <tr>
                            <th>
                                <h5>
                                    {{ $prospectState->title }}
                                </h5>
                            </th>
                            <th>
                                <h5>
                                    {{ strlen($prospectState->description) > 40 ? substr($prospectState->description, 0, 40) . '...' : $prospectState->description }}
                                </h5>
                            </th>
                            <th>
                                <h5>
                                    @if ($prospectState->states()->count())
                                        @php
                                            $statesString = '';
                                        @endphp
                                        @foreach ($prospectState->states()->limit(3)->get() as $state)
                                            @php
                                                $statesString .= $state->title . ', ';
                                            @endphp
                                        @endforeach
                                        {{ substr($statesString, 0, strlen($statesString) - 2) . ' ' }}
                                        @if ($prospectState->states()->count() > 3)
                                            and more
                                        @endif
                                    @else
                                        Nothing yet.
                                    @endif
                                </h5>
                            </th>
                            <th>
                                <a class="btn btn-primary"
                                    href="{{ route('user.prospect_states.edit', ['prospect_state' => $prospectState]) }}">
                                    Edit
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
