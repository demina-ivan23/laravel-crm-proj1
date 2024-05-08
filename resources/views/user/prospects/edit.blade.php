@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('user.prospects.dashboard')}}" class="btn btn-light">Go Back To Prospects</a>
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
                                <li><a class="dropdown-item" href="{{ route('user.prospects.dashboard')}}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.prospects.show', ['prospect' => $prospect])}}">View "{{$prospect->name}}"</a></li>
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
            
            <form action="{{ route('user.prospects.update', ['prospect' => $prospect->id]) }}" method="POST" enctype="multipart/form-data">
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
    <div class="mb-3">
        <label for="custom_state" class="form-label">Prospect state</label>
        @php
            $prospect_states = App\Models\ProspectState::where('title', '!=', $prospect->state->title)->get();
        @endphp
        <div class="dropdown">
            <select class="form-control" name="prospect_state" id="prospect_state_select" @change="handleProspectStateChange()">
                <option value="{{$prospect->state->title}}">{{$prospect->state->title}}</option>
                <option value="{{null}}">auto</option>
                @if ($prospect_states->count())
                @foreach ($prospect_states as $state)
                <option value="{{$state->title}}">{{$state->title}}</option>
                @endforeach
                @endif
                <option value="custom">Custom state</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <div v-if="showCustomProspectStateInput">
            <input type="text" class="form-control" id="custom_prospect_state" name="custom_prospect_state" placeholder="Enter custom prospect state">
        </div>
    </div>

        <button class="btn btn-primary float-end mb-2" type="submit">
            Edit
        </button>

    </div>
</form>


</div>
</div>
@endsection