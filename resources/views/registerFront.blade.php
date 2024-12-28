@extends('layout.layout')
@section('content')
<style>
    .form-control {
  border: 2px solid #c17a74; /* Sets the border color */
  border-radius: 4px; /* Optional: to make the corners slightly rounded */
  padding: 10px; /* Optional: for better spacing */
}

.form-control:focus {
  border-color: #a56560; /* Optional: Change border color on focus */
  outline: none; /* Remove default focus outline */
  box-shadow: 0 0 5px #c17a74; /* Optional: Add a subtle glow effect */
}

</style>
<div class="container custom-login">
    <div class="row">
        <div class="col-sm-12">
            <form action="register" method="POST">
              @csrf
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter User Name">
              </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input  type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
              </form>
        </div>
    </div>
</div>
@endsection