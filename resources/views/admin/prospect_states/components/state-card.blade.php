<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="d-flex justify-content-center">
                    <p style="font-weight: 600">Title: {{ $prospectState->title }}</p>
                </div>
                <div class="d-flex justify-content-center">
                    <p style="font-weight: 600">Description: {{ $prospectState->description }}</p>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center align-items-center">
                <div class="">

                    @if ($prospectState->states()->count())
                        <div class="">A prospect with this state can transit to:</div>
                        <ul>
                            @foreach ($prospectState->states as $state)
                            <li>{{ $state->title }}</li>
                            @endforeach
                        </ul>
                    @else
                        <div class="">A prospect with this state can't transit to any other state yet</div>
                    @endif
                </div>

            </div>
            <div class="col-sm-3 d-flex justify-content-between align-items-center">
                <a class="btn btn-primary "
                    href="{{ route('admin.prospect_states.edit', ['prospect_state' => $prospectState]) }}">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>
