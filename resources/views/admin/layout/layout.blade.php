<!DOCTYPE html>
<html>
@include('admin.includes.head')

<body class="skin-blue">
  <div class="wrapper">
    @include('admin.includes.nav')
    <!-- Left side column. contains the logo and sidebar -->
@include('admin.includes.sidebar')

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>
      @yield('content')


    </div><!-- /.content-wrapper -->
@include('admin.includes.footer')