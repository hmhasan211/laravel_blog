<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{asset('storage/profile/'.Auth::User()->image)}}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ \Illuminate\Support\Facades\Auth::user()->name }}</div>
            <div class="email">{{ \Illuminate\Support\Facades\Auth::user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{Auth::user()->role_id == 1 ? route('admin.settings') : route('author.settings')}}"><i class="material-icons">person</i>Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i><span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>

  {{--  Author section--}}
            @if(\Illuminate\Support\Facades\Request::is('admin*'))
                <li >
                    <a target="_blank" href="{{ route('home') }}">
                        <i class="material-icons">computer</i>
                        <span>Visit Site</span>
                    </a>
                </li>

                <li class="{{Request::is('admin/dashboard')?'active':''}}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/tag*')?'active':'' }}">
                    <a href="{{ route('admin.tag.index') }}">
                        <i class="material-icons">tag</i>
                        <span>Tags</span>
                    </a>
                </li>
                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/category*')?'active':'' }}">
                    <a href="{{ route('admin.category.index') }}">
                        <i class="material-icons">apps</i>
                        <span>Category</span>
                    </a>
                </li>
                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/post*')?'active':'' }}">
                    <a href="{{ route('admin.post.index') }}">
                        <i class="material-icons">library_books</i>
                        <span>Post</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/pending/post')?'active':'' }}">
                    <a href="{{ route('admin.post.pending') }}">
                        <i class="material-icons">library_books</i>
                        <span>Pending Post</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/favourite') ?'active':'' }}">
                    <a href="{{ route('admin.favourite.index') }}">
                        <i class="material-icons">favorite</i>
                        <span>Favourite Post</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/comments') ?'active':'' }}">
                    <a href="{{ route('admin.comments.index') }}">
                        <i class="material-icons">comment</i>
                        <span>Comments</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/authors')?'active':'' }}">
                    <a href="{{route('admin.authors.index')}}">
                        <i class="material-icons">person_add</i>
                        <span>Authors</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/subscriber')?'active':'' }}">
                    <a href="{{route('admin.subscriber.index')}}">
                        <i class="material-icons">subscriptions</i>
                        <span>Subscribers</span>
                    </a>
                </li>
                <li class="header">System</li>
                <li class="{{ \Illuminate\Support\Facades\Request::is('admin/settings')?'active':'' }}">
                    <a href="{{route('admin.settings')}}">
                        <i class="material-icons">settings</i>
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i><span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endif

{{--  Author section--}}
            @if(\Illuminate\Support\Facades\Request::is('author*'))
                <li >
                    <a target="_blank" href="{{ route('home') }}">
                        <i class="material-icons">computer</i>
                        <span>Visit Site</span>
                    </a>
                </li>
                <li class="{{ Request::is('author/dashboard') ? 'active':'' }}">
                    <a href="{{ route('author.dashboard') }}">
                        <i class="material-icons">home</i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('author/post*') ? 'active' : '' }}">
                    <a href="{{ route('author.post.index') }}">
                        <i class="material-icons">library_books</i>
                        <span>Post</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('author/favourite') ?'active':'' }}">
                    <a href="{{ route('author.favourite.index') }}">
                        <i class="material-icons">favorite</i>
                        <span>Favourite Post</span>
                    </a>
                </li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('author/comments') ?'active':'' }}">
                    <a href="{{ route('author.comments.index') }}">
                        <i class="material-icons">comment</i>
                        <span>Comments</span>
                    </a>
                </li>

                <li class="header">System</li>

                <li class="{{ \Illuminate\Support\Facades\Request::is('author/settings')?'active':'' }}">
                    <a href="{{route('author.settings')}}">
                        <i class="material-icons">settings</i>
                        <span>Settings</span>
                    </a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i><span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endif

        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
{{--    <div class="legal">--}}
{{--        <div class="copyright">--}}
{{--            &copy; <a href="#">hamid hasan</a>.--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- #Footer -->
</aside>
