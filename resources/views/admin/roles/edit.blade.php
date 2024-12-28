@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
    .checkbox-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px; /* Space between items */
}

.checkbox-item {
    flex: 1 1 calc(25% - 15px); /* 4 items per row with gap adjustment */
    display: flex;
    align-items: center;
}

.checkbox-item input[type="checkbox"] {
    margin-right: 8px; /* Space between checkbox and label */
}

.checkbox-container label {
    color: black;
}

</style>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add your permission</h4>
            <form class="forms-sample" action="{{route('role.update',$role->id)}}" method="post" enctype="multipart/form-data"
                id="form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="exampleInputName1">Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="name" value="{{$role->name}}" name="name">
                    <div class="error"> @error('name') {{$message}} @enderror</div>
                </div>
                @php

                $permi = $role->permissions->pluck('name')->toArray();
                // dd($permi);
                    
                @endphp

                    <div class="checkbox-container">
                        <div style="width: 100%">
                            <input type="checkbox" name="select" id="selectAll">
                            <label for="selectAll">Select All</label>
                        </div>
                        @foreach($permissions as $permission)
                        <div class="checkbox-item">
                            <input type="checkbox" name="permissions[]" class="permission-checkbox" value="{{ $permission->name }}" 
                                {{ in_array($permission->name, $permi) ? 'checked' : '' }}>
                            <label for="permission" style="color: black">{{ $permission->name }}</label>
                        </div>
                        @endforeach
                    </div>

                <button type="submit" class="btn btn-primary mr-2">Update</button>
                {{-- <button type="button" class="btn btn-secondary addFild">Add Role</button> --}}
            </form>
        </div>
    </div>
</div>
</section>

{{-- <script>
    $(document).ready(function() {
        $('.addFild').click(function() {
            // alert('hii');
            let Data = '<div class="div">\
            <div class="form-group mt-4">\
                    <label for="exampleInputName1">Name</label>\
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="name" name="RoleName[]">\
            </div>\
            <button type="button" class="remove">Remove</button>\
                </div>';

                $('#form').append(Data);
        })
        $('#form').on('click','.remove',function(){
            // alert('hii')
            $(this).closest('.div').remove();
        })
    })
</script> --}}
<script>
    const selectAllCheckbox = document.getElementById('selectAll');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

    selectAllCheckbox.addEventListener('click', function() {
        permissionCheckboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    permissionCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            selectAllCheckbox.checked = Array.from(permissionCheckboxes).every(cb => cb.checked);
        });
    });
</script>
@endsection