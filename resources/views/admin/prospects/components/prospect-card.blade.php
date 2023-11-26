<div class="card mt-3 prospect-card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3 d-flex justify-content-center">
@if ($prospect->profile_image)


    <img src="{{Storage::url($prospect->profile_image)}}" alt="" width="100" height="100"> 
@else
<img src="/prospects/profiles/images/user.png" width="105"  alt="">
@endif
      
            </div>
            <div class="col-sm-6">
                <h5>{{ $prospect->name }}</h5>
                 <ul>
                    <strong>Email: </strong> {{ $prospect->email }}
                   <li>
                    <strong>Date Of Creation: </strong> {{ $prospect->dateForHumans }}
                   </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Actions 
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.prospects.show', ['prospect' => $prospect->id])}}">View "{{$prospect->name}}"</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.prospects.edit', ['prospect' => $prospect->id])}}">Edit</a></li>
                    <li>  <form action="{{ route('admin.prospects.destroy', ['prospect' => $prospect->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this prospect?')">Delete</button>
                    </form>
                    </li>
                    </ul>
                  </div>
            </div>
        </div>
    </div>
</div>