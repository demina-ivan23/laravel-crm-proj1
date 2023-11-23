@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Edit The Prospect "{{ $prospect->name }}"</h2>
                    
                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.prospects.dashboard')}}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.prospects.show', ['prospect' => $prospect->id ])}}">View "{{$prospect->name}}"</a></li>
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
            
            <form action="{{ route('admin.prospects.update', ['prospect' => $prospect->id]) }}" method="PUT" enctype="multipart/form-data">
                @csrf

<div class="p-3">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input class="form-control" type="text" name="name" id="name" placeholder="Prospect's name..." value="{{$prospect->name}}">
    </div>
    
    <div class="mb-3">
        
        <label for="email" class="form-label">Email</label>
        <input class="form-control" type="email" name="email" id="email" value="{{$prospect->email}}">
    </div>
    
    <div class="mb-3">
        <label for="profileImage" class="form-label">Profile Image</label>
        <input  class="form-control" type="file" name="profile_image" id="profileImage">
    </div>
    

        <button class="btn btn-primary float-end mb-2" type="submit">
            Edit
        </button>

    </div>
</div>

</div>
</form>


</div>
</div>
@endsection