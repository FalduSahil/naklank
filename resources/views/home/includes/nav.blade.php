<nav class="navbar py-lg-4 py-3 px-0 border-bottom navbar-menu">
    <div class="container-fluid">
        <div class="row w-100 align-items-center g-0 gx-lg-3">
            <div class="col-xxl-9 col-lg-8">
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler collapsed d-none d-lg-block" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#navbar-default2" aria-controls="navbar-default2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                             class="bi bi-text-indent-right text-primary" viewBox="0 0 16 16">
                            <path
                                    d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm10.646 2.146a.5.5 0 0 1 .708.708L11.707 8l1.647 1.646a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2zM2 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                    <a class="navbar-brand d-none d-lg-block ms-4" href="{{ route('home') }}">
                        <img height="40" src="{{ getPath('common') }}/images/64.png"
                             alt="{{ getConstant('SITE_NAME') }}"/>
                    </a>
                    <div class="d-flex w-100 ms-4">
                        <form action="#" class="w-100 d-none d-lg-block">
                            <div class="input-group">
                                <input class="form-control rounded" type="search" placeholder="Search for products"/>
                                <span class="input-group-append">
                                 <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                         type="button">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-search">
                                       <circle cx="11" cy="11" r="8"></circle>
                                       <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                 </button>
                              </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-between w-100 d-lg-none align-items-center">
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#navbar-default2" aria-controls="navbar-default2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                             class="bi bi-text-indent-left text-primary" viewBox="0 0 16 16">
                            <path
                                    d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </button>
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img height="40" src="{{ getPath('common') }}/images/64.png"
                             alt="{{ getConstant('SITE_NAME') }}"/>
                    </a>
                    <div class="d-flex align-items-center lh-1">
                        <div class="list-inline me-2">
                            <div class="list-inline-item">
                                @guest
                                    <a href="{{ route('login') }}" class="text-muted">
                                        <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </a>
                                @endguest
                                @auth
                                    <a href="#" class="text-muted me-5">
                                        <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    </a>
                                    <a href="{{ route('logoutUser') }}" class="text-muted">
                                        <i class="feather-icon icon-log-out"></i>
                                    </a>
                                @endauth
                            </div>
                        </div>
                        <!-- Button -->
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-lg-4 d-flex align-items-center justify-content-end">
                <div class="list-inline d-lg-block d-none">
                    <div class="list-inline-item me-5">
                        @guest
                            <a href="{{ route('login') }}" class="text-reset">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        @endguest
                        @auth
                            <a href="#" class="text-reset me-5">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                            <a href="{{ route('logoutUser') }}" class="text-reset">
                                <i class="feather-icon icon-log-out"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-start p-4 w-xxl-20 w-lg-30" id="navbar-default2">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <a href="{{ route('home') }}"><img height="100px" src="{{ getPath('common') }}/images/logo.png"
                                                   alt="{{ getConstant('SITE_NAME') }}"/></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="my-4">
                <form action="#">
                    <div class="input-group">
                        <input class="form-control rounded" type="search" placeholder="Search for products"/>
                        <span class="input-group-append">
                           <button class="btn bg-white border border-start-0 ms-n10 rounded-0 rounded-end"
                                   type="button">
                              <svg
                                      xmlns="http://www.w3.org/2000/svg"
                                      width="16"
                                      height="16"
                                      viewBox="0 0 24 24"
                                      fill="none"
                                      stroke="currentColor"
                                      stroke-width="2"
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      class="feather feather-search">
                                 <circle cx="11" cy="11" r="8"></circle>
                                 <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                              </svg>
                           </button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="mb-4 mt-2 h-100" data-simplebar="">
                <ul class="navbar-nav navbar-nav-offcanvac">
                    <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true"
                           aria-expanded="false">Home</a>
                    </li>
                    <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true"
                           aria-expanded="false">Shop</a>
                    </li>
                    <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true"
                           aria-expanded="false">Categories</a>
                    </li>
                    <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true"
                           aria-expanded="false">Cart</a>
                    </li>
                    <li class="nav-item dropdown dropdown-flyout">
                        <a class="nav-link" href="{{ route('home') }}" role="button" aria-haspopup="true"
                           aria-expanded="false">Account</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>