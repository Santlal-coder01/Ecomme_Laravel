<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{Auth::user()->getFirstMediaUrl('image')}}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p>{{Auth::user()->name}}</p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..." />
        <span class="input-group-btn">
          <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}">
        <a href="{{route('dashboard')}}">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview">
        <a href="{{route('user.index')}}">
          <i class="fa fa-user"></i> <span>Users</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview  {{ Route::currentRouteName() == 'permission.index' ? 'active' : '' }}">
        <a href="{{route('permission.index')}}">
          <i class="fa fa-lock"></i>
          <span>Permissions</span>
          {{-- <span class="label label-primary pull-right">4</span> --}}
        </a>
      </li>
      <li class=" treeview{{ Route::currentRouteName() == 'role.index' ? 'active' : '' }}">
        <a href="{{route('role.index')}}">
          <i class="fa fa-circle-o"></i> <span>Roles</span>
        </a>
      </li>
      <li class="treeview {{ Route::currentRouteName() == 'block.index' ? 'active' : '' }}">
        <a href="{{route('block.index')}}">
          <i class="fa fa-bookmark"></i>
          <span>Blocks</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview {{ Route::currentRouteName() == 'slider.index' ? 'active' : '' }}">
        <a href="{{route('slider.index')}}">
          <i class="fa fa-laptop"></i>
          <span>Sliders</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>

      @can('page_index')
      <li class="treeview {{ Route::currentRouteName() == 'page.index' ? 'active' : '' }}">
        <a href="{{route('page.index')}}">
          <i class="fa fa-files-o"></i> <span>Pages</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      @endcan
      <li class="treeview">
        <a href="{{route('enquiry.index')}}">
          <i class="fa fa-share"></i> <span>Enquiries</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="header">LABELS</li>

      @can('category_index')
      <li class="treeview {{ Route::currentRouteName() == 'category.index' ? 'active' : '' }}">
        <a href="{{route('category.index')}}">
          <i class="fa fa-list-alt"></i> <span>Categories</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      @endcan
      <li class="treeview {{ Route::currentRouteName() == 'product.index' ? 'active' : '' }}">
        <a href="{{route('product.index')}}">
          <i class="fa fa-bars"></i> <span>Products</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview {{ Route::currentRouteName() == 'attribute.index' ? 'active' : '' }}">
        <a href="{{route('attribute.index')}}">
          <i class="fa fa-tag"></i> <span>Attributes</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview {{ Route::currentRouteName() == 'attribute-values.index' ? 'active' : '' }}">
        <a href="{{route('attribute-values.index')}}">
          <i class="fa fa-asterisk"></i> <span>AttributeValues</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>
      <li class="treeview {{ Route::currentRouteName() == 'coupon.index' ? 'active' : '' }}">
        <a href="{{route('coupon.index')}}">
          <i class="fa fa-bars"></i>
          <span>Coupons</span>
          {{-- <i class="fa fa-angle-left pull-right"></i> --}}
        </a>
      </li>

    
      <li><a href="{{route('logout')}}"><i class="fa fa-circle-o text-danger"></i> Log-Out</a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>