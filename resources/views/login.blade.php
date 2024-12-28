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
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{route('loginFrontPost')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                id="email"
                                value="{{ session('email', '') }}" 
                                placeholder="Enter email"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                id="password"
                                value="{{ session('password', '') }}"
                                placeholder="Enter password"
                                required
                            >
                        </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>    

@endsection