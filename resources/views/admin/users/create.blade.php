@extends('admin.layout.layout')
@section('content')   
<style>
.error{
  color: red;
}
</style>
<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
      <h4 class="card-title">USER RAGISTRATION</h4>
      <p class="card-description"> USER RAGISTRATION </p>
      <form class="forms-sample" action="{{route('user.store')}}" id="form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="exampleInputName">Name</label>
          <input type="text" class="form-control" id="name" placeholder="Name" name="name">
          <div class="error"> @error('name') {{$message}} @enderror</div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail3">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="Email" name="email">
          <div class="error"> @error('email') {{$message}} @enderror</div>
        </div>
        <div class="form-group">
          <label for="exampleInputPhoto">Image</label>
          <input type="file" class="form-control" id="image" name="image" multiple>
          <div class="error"> @error('image') {{$message}} @enderror</div>
        </div>
        {{-- <div class="form-group">
          <label for="exampleInputcontact">Contact No</label>
          <input type="tel" class="form-control" id="contact" placeholder="contact-no" name="contact">
          <div class="error"> @error('contact') {{$message}} @enderror</div>
        </div> --}}
        <div class="form-group">
          <label for="exampleInputPassword">Password</label>
          <input type="password" class="form-control" id="password" placeholder="Password" name="password">
          <div class="error"> @error('password') {{$message}} @enderror</div>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword">Confirm Password</label>
          <input type="password" class="form-control" id="password" placeholder="Confirm Password" name="con_password">
          <div class="error"> @error('con_password') {{$message}} @enderror</div>
        </div>
        <h4>Roles</h4> 
        <div class="checkbox-container">
          @foreach($roles as $role)
              <div class="checkbox-item">
                  <input type="checkbox" name="roles[]" id="permission" value="{{$role->name}}">
                  <label for="check" style="color: black">{{$role->name}}</label>
              </div>
          @endforeach
      </div>
        <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
        <button class="btn btn-light" type="reset">Cancel</button>
      </form>
      </div>
    </div>
  </div>
</section>

@endsection
{{-- 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> --}}
  

</body>

</html>

