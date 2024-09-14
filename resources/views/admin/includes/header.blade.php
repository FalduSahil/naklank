<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a title="Profile" class="nav-link" href="{{ route('adminProfile') }}" role="button">
                <i class="fa fa-user"></i>
            </a>
        </li>
        <li class="nav-item">
            <a title="Full Screen" class="nav-link" data-widget="fullscreen" href="javascript:void(0)" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <form id="logoutForm" class="d-none" method="post" action="{{ route('logoutAdmin') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
            <a title="Logout" onclick="$('#logoutForm').submit();" class="nav-link" href="javascript:void(0)" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
