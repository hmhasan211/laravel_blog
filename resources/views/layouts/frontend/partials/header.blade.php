<header>
    <div class="container-fluid position-relative no-side-padding">


        <a href="{{asset('/')}}" class="main-menu logo" ><img src="{{asset('storage/hsn.png')}}"  alt="Logo Image"></a>
        <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

        <ul class="main-menu visible-on-click" id="main-menu">
            <li><a href="{{route('home')}}">Home</a></li>
            <li><a href="#">Categories</a></li>
            @guest()
                <li><a target="_blank" href="{{route('login')}}">Login</a></li>
                <li><a target="_blank" href="{{route('register')}}">Register</a></li>
            @else
                @if(Auth::user()->rold_id == 1)
                    <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                @else
                    <li><a href="{{route('author.dashboard')}}">Dashboard</a></li>
                    @endif
            @endguest
        </ul><!-- main-menu -->

        <div class="src-area">
            <form method="GET" action="{{route('search')}}">
                <button class="src-btn" type="submit"><i class="fa fa-search"></i></button>
                <input class="src-input" value="{{isset($query) ? $query : ''}}" name="query" type="text" placeholder="Type of search">
            </form>
        </div>

    </div><!-- conatiner -->
</header>
