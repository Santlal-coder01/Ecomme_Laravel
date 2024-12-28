@extends('admin.layout.layout')
@section('content')
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
                <h4 class="card-title">USER EDIT</h4>
                <p class="card-description"> USER EDIT PROFILE</p>
                <form class="forms-sample" action="{{route('user.update',$user->id)}}" id="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Full Name" name="name" value="{{$user->name}}">
                    <div class="error"> @error('name') {{$message}} @enderror</div>
                  </div>
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$user->email}}">
                    <div class="error"> @error('email') {{$message}} @enderror</div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhoto">Image</label>
                    <img src="{{$user->getFirstMediaUrl('image')}}"  style="width:100px;height:100px;margin:10px">
                    <input type="file" class="form-control" id="image" name="image">
                    <div class="error"> @error('image') {{$message}} @enderror</div>
                  </div>
                  {{-- <div class="form-group">
                    <label for="contact">Contact No</label>
                    <input type="phone" class="form-control" id="contact" placeholder="contact-no" name="contact" value="{{$user->contact}}">
                    <div class="error"> @error('contact') {{$message}} @enderror</div>
                  </div> --}}
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" name="password" value="">
                    <div class="error"> @error('password') {{$message}} @enderror</div>
                  </div>
                  <h4>Roles</h4>
                  @php 
                  $rol = $user->roles->pluck('name')->toArray();
                  // dd($role);
                  @endphp 
                  <div class="checkbox-container">
                    @foreach($roles as $role)
                        <div class="checkbox-item">
                            <input type="checkbox" name="roles[]" id="roles" {{ in_Array($role->name,$rol)?'checked':''}} value="{{$role->name}}">
                            <label for="roles" style="color: black">{{$role->name}}</label>
                        </div>
                    @endforeach
                </div>
                  <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>  
                  <button class="btn btn-light" type="reset">Cancel</button>
                </form>
          </div>
        </div>
      </div>
</section>
@endsection
</body>

</html>