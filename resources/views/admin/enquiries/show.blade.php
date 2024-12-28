@extends('admin.layout.layout')
@section('content')
<div class="container">
    <h2>Enquiry Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Enquiry ID: {{ $enquiry->id }}</h5>
            <p><strong>Status:</strong> {{ $enquiry->status == 1 ? 'Unread' : 'Read' }}</p>
            <p><strong>Name:</strong> {{ $enquiry->name }}</p>
            <p><strong>Email:</strong> {{ $enquiry->email }}</p>
            <p><strong>Message:</strong> {{ $enquiry->message }}</p>
        </div>
        <a href="{{ route('enquiry.index') }}" class="btn btn-primary">Back to Enquiries</a>
    </div>
</div>
@endsection
