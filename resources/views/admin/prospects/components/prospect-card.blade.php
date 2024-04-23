<div class="card mt-3 prospect-card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3 d-flex justify-content-center align-items-center">

<img src="/prospects/profiles/images/user.png" width="105" height="105"  alt="">

      
            </div>
            <div class="col-sm-6">
                <h5>{{ $prospect->name }}</h5>
                 <ul>
                    <strong>Email: </strong> {{ $prospect->email }}
                   <li>
                    <strong>Date Of Creation: </strong> {{ $prospect->dateForHumans }}
                   </li>
                   <li>
                    <strong>State: </strong> {{ $prospect->prospectState }}
                   </li>
                   @if ($prospect->phone_number !== null)    
                   <li>
                    <strong>Phone Number: </strong> {{ $prospect->phone_number }}
                   </li>
                   @endif
                   @if ($prospect->address !== null)  
                   <li>
                    <strong>Address: </strong> {{ $prospect->address }}
                   </li>
                   @endif
                   @if ($prospect->facebook_account !== null)  
                   <li>
                    <strong>Facebook Account: </strong> {{ $prospect->facebook_account }}
                   </li>
                   @endif
                   @if ($prospect->instagram_account !== null)  
                   <li>
                    <strong>Instagram Account: </strong> {{ $prospect->instagram_account }}
                   </li>
                   @endif

                </ul>
            </div>
            <div class="col-sm-3">
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Actions 
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.prospects.show', ['prospect' => $prospect])}}">View "{{$prospect->name}}"</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.prospects.edit', ['prospect' => $prospect])}}">Edit</a></li>
                      <li><a class="dropdown-item" href="{{route('admin.orders.create.select_products', ['prospect' => $prospect])}}">Make An Order For "{{$prospect->name}}"</a></li>
                      <li><a class="dropdown-item" href="{{route('admin.prospects.show-orders', ['prospect' => $prospect])}}">View Orders Of "{{$prospect->name}}"</a></li>
                      <li><form action="{{ route('admin.prospects.destroy', ['prospect' => $prospect]) }}" method="POST">
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