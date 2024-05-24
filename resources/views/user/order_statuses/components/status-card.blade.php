<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="d-flex justify-content-center">
                    <p style="font-weight: 600">Title: {{ $order_status->title }}</p>
                </div>
                <div class="d-flex justify-content-center">
                    <p style="font-weight: 600">Description: {{ $order_status->description }}</p>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center align-items-center">
                {{ $order_status->can_transit_into }}
            </div>
            <div class="col-sm-3 d-flex justify-content-between align-items-center">
                <a class="btn btn-primary "
                    href="{{ route('user.order_statuses.edit', ['order_status' => $order_status]) }}">
                    Edit
                </a>
                <form action="{{route('user.order_statuses.update', ['order_status' => $order_status])}}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($order_status->first_step_status)
                    <input type="hidden" name="first_step_status" id="first_step_status" value="0">
                    <input type="submit" class="btn btn-primary" value="Disable FSS" title="FSS - first step status (for order creation). You can have multiple FSSs">
                    @else
                    <input type="hidden" name="first_step_status" id="first_step_status" value="1">
                    <input type="submit" class="btn btn-primary" value="Enable FSS" title="FSS - first step status (for order creation). You can have multiple FSSs">
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
