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
            
            <form action="{{ route('admin.prospects.contacts.store', ['prospect' => $prospect->id])}}" method="POST" enctype="multipart/form-data">
                @csrf

<div class="p-3">

    <div class="mb-3">
        <label for="phone_number" class="form-label">Phone number</label>
        <input class="form-control" type="text" name="phone_number" id="phone_number" placeholder="Prospect's phone number...">
    </div>
    
    <div class="mb-3">
        <label for="facebook_account" class="form-label">Facebook account</label>
        <input class="form-control" type="text" name="facebook_account" id="facebook_account" placeholder="Prospect's Facebook account...">
    </div>
    
    <div class="mb-3">
        <label for="instagram_account" class="form-label">Instagram account</label>
        <input class="form-control" type="text" name="instagram_account" id="instagram_account" placeholder="Prospect's Instagram account...">
    </div>
    
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input class="form-control" type="text" name="address" id="address" placeholder="Prospect's address...">
    </div>

    <div class="mb-3">
        <label for="personal_info" class="form-label">Personal info</label>
        <input class="form-control" type="text" name="personal_info" id="personal_info" placeholder="Some additional info...">
    </div>
    <div class="mb-3">
        <label for="custom_state" class="form-label">Custom state</label>
        <input class="form-control" type="text" name="custom_state" id="custom_state" placeholder="Create a custom state...">
    </div>
        <button class="btn btn-primary float-end mb-2" type="submit">
            Create
        </button>

    </div>
</div>

</div>
</form>


</div>
</div>
@endsection