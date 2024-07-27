<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('dashboard')}}" class="nav-link">Home</a>
        </li>
    </ul>
    <!-- Add a separate list for items that should be on the right -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-4">
            <form method="POST" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="nav-link" >
                    <i class="fa-solid fa-right-from-bracket" style="font-size:26px"></i>
                </button>
            </form>
        </li>
    </ul>
</nav>
