@extends('layouts.app')

@section('content')
    <div class="container">
      <a href="{{route('admin.prospects.dashboard')}}" class="btn btn-light">Go Back To Prospects</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Create Contacts For Prospect "{{$prospect->name}}"</h2>
                    
                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.prospects.dashboard')}}">Dashboard</a></li>
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
            
            <form action="{{ route('admin.prospects.update', ['prospect' => $prospect->id]) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
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
    

    <div class="mb-3">
        <label for="phone_number" class="form-label">Phone number</label>
        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Prospect's phone number..." value="{{$prospect->phone_number}}">
    </div>
    
    <div class="mb-3">
        <label for="facebook_account" class="form-label">Facebook account</label>
        <input class="form-control" type="text" name="facebook_account" id="facebook_account" placeholder="Prospect's Facebook account..." value="{{$prospect->facebook_account}}">
    </div>
    
    <div class="mb-3">
        <label for="instagram_account" class="form-label">Instagram account</label>
        <input class="form-control" type="text" name="instagram_account" id="instagram_account" placeholder="Prospect's Instagram account..." value="{{$prospect->instagram_account}}">
    </div>
    
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input class="form-control" type="text" name="address" id="address" placeholder="Prospect's address..." value="{{$prospect->address}}">
    </div>

    <div class="mb-3">
        <label for="personal_info" class="form-label">Personal info</label>
        <input class="form-control" type="text" name="personal_info" id="personal_info" placeholder="Some additional info..." value="{{$prospect->personal_info}}">
    </div>
        <button class="btn btn-primary float-end mb-2" type="submit">
            Edit
        </button>

    </div>
</form>
</div>

</div>

@endsection