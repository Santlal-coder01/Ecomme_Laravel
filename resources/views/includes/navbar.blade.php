 @if(Request::is('/'))
    <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
        data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
        <h6 class="m-0">Categories</h6>
        <i class="fa fa-angle-down text-dark"></i>
    </a>
    <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
        id="navbar-vertical">
        @else
        <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100 collapsed"
            data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;"
            aria-expanded="false">
            <h6 class="m-0">Categories</h6>
            <i class="fa fa-angle-down text-dark"></i>
        </a>
        <nav class="position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light collapse"
            id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
            @endif
            <div class="navbar-nav w-100 overflow-hidden" style="height: 300px;">
                @foreach(category() as $parentCategory)
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link" data-toggle="dropdown">{{$parentCategory->name}}<i
                            class="fa fa-angle-down float-right mt-1"></i></a>
                    <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                        @foreach(subCategory($parentCategory->id) as $subCategory)
                        <a href="{{route('subCatg',$subCategory->url_key)}}"
                            class="dropdown-item">{{$subCategory->name}}</a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="{{route('/')}}" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper
                    </h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{route('/')}}" class="nav-item nav-link active">Home</a>
                        @foreach(category() as $parentCategory)
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{$parentCategory->name}}</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    @foreach(subCategory($parentCategory->id) as $subCategory)
                                        <a href="{{route('subCatg', $subCategory->url_key)}}" class="dropdown-item">{{$subCategory->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <a href="{{route('contact')}}" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0">
                        @auth
                            <!-- If user is logged in, show dropdown with Profile, Orders, etc. -->
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    My Account
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('show_profile') }}" class="dropdown-item">Profile</a>
                                    {{-- <a href="{{ route('user_payment_methods') }}" class="dropdown-item">Payment Methods</a> --}}
                                    <a href="{{ route('user_orders') }}" class="dropdown-item">Orders</a>
                                    <a href="{{ route('user_address') }}" class="dropdown-item">Address</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('logoutfront') }}" class="dropdown-item">Logout</a>
                                </div>
                            </div>
                        @else
                            <!-- If user is not logged in, show Login and Register links -->
                            <a href="{{route('loginFront')}}" class="nav-item nav-link">Login</a>
                            <a href="{{route('ragisterFront')}}" class="nav-item nav-link">Register</a>
                        @endauth
                    </div>
                </div>
            </nav>

        
