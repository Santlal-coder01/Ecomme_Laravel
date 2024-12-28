@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
</style>
<section class="container sm-4 offset-4 mt-4 mb-4">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-danger">
        <h4 class="card-title">Change Password</h4>
        <form action="{{ route('password.update') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
            @error('current_password')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
            @error('new_password')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            @error('confirm_password')
              <div class="error">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
