@extends('admin.layout.layout')
@section('content')   
<style>
  .profile-label {
    font-weight: bold;
  }
  .profile-value {
    color: #333;
  }
  .profile-section {
    padding: 37px;
     margin-top: 20px;
     width: 95%;
  }
</style>
<section class="container sm-4 offset-4 mt-4 mb-4">
    <div class="row">
    <div class="container">
        @foreach($users as $user)
      <div class="box box-info profile-section">
        <h4 class="card-title">USER PROFILE</h4>
        {{-- <p class="card-description">View your profile details</p> --}}
      
        <div class="form-group">
          <label class="profile-label">Name:</label>
          <span class="profile-value">{{ $user->name }}</span>
        </div>
        <div class="form-group">
          <label class="profile-label">Email Address:</label>
          <span class="profile-value">{{ $user->email }}</span>
        </div>
        <div class="form-group">
          <label class="profile-label">Image:</label> 
            <img src="{{$user->getFirstMediaUrl('image')}}" alt="Profile Image" style="width: 100px; height: auto;">
        </div>
        {{-- <div class="form-group">
          <label class="profile-label">Roles:</label>
          <span class="profile-value">
            @if($user->roles->isNotEmpty())
              @foreach($user->roles as $role)
                {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
              @endforeach
            @else
              No roles assigned
            @endif
          </span>
        </div> --}}
      </div>
      @endforeach
      <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary mr-2">Edit Profile</a>
      <a href="{{route('changePass')}}"  class="btn btn-secondary mr-2">Change Password</a>
      <a href="{{ route('user.index') }}" class="btn btn-light">Back</a>
    </div>
  </div>

</section>
@endsection
