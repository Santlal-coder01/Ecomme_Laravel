@extends('layout.layout')
@section('content')
<style>
.text {
  text-align: center;
  height: 120px;
  padding-top: 35px;
  background: #ccc;
  font-size: 40px;
}

</style>
<div class="col-md-9 col-sm-9">
    <h1 class="text">{{$pages->name}}</h1>
    <div class="content-page">
        <p><img src="{{$pages->getFirstMediaUrl('img')}}" alt="About us" width="100%" height="700px" class="img-responsive"></p>

        <p> {!!$pages->description!!}  </p>

    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END SIDEBAR & CONTENT -->
</div>
</div>


@endsection