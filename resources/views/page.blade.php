@extends('layout.layout')
@section('content')
<style>
.container-page {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: space-between;
  align-items: center;
}

.image-section {
  flex: 1;
  max-width: 50%;
}

.image-section img {
  width: 100%;
  height: auto;
  border-radius: 8px;
}

.content-section {
  flex: 1;
  max-width: 50%;
  font-size: 18px;
  line-height: 1.6;
}

.text {
  text-align: center;
  padding: 40px 0;
  background: #f4f4f4;
  font-size: 32px;
  font-weight: bold;
  color: #333;
  width: 60%;
  margin:auto;
  margin-bottom: 50px;
}

@media (max-width: 768px) {
  .container-page {
    flex-direction: column;
  }
  .image-section, .content-section {
    max-width: 100%;
  }
}

</style>

<div class="col-md-9 col-sm-9">
    <h1 class="text">{{$pages->name}}</h1>
    <div class="container-page">
        <!-- Image Section -->
        <div class="image-section">
            <img src="{{$pages->getFirstMediaUrl('img')}}" alt="About us" class="img-responsive">
        </div>
        <!-- Content Section -->
        <div class="content-section">
            <p>{!!$pages->description!!}</p>
        </div>
    </div>
</div>
<!-- END CONTENT -->
@endsection
