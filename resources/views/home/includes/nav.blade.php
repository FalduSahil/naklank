<header class="py-lg-5 py-4 border-bottom border-bottom-lg-0">
    <div class="container">
        <div class="row w-100 align-items-center gx-3">
            <div class="col-xl-5 col-lg-4">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand d-none d-lg-block" href="{{ route('home') }}">
                        <img height="60px" src="{{ getPath('common') }}/images/64.png"
                             alt="{{ getConstant('SITE_NAME') }}"/>
                    </a>
                </div>
                <div class="d-flex justify-content-between align-items-center w-100 d-lg-none">
                    <a class="navbar-brand mb-0" href="{{ route('home') }}">
                        <img height="60px" src="{{ getPath('common') }}/images/64.png"
                             alt="{{ getConstant('SITE_NAME') }}"/>
                    </a>

                    <div class="d-flex align-items-center lh-1">
                        <button
                                class="navbar-toggler collapsed"
                                type="button"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#navbar-default"
                                aria-controls="navbar-default"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                 class="bi bi-text-indent-left text-primary" viewBox="0 0 16 16">
                                <path
                                        d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 col-lg-8 d-flex align-items-center">
                <div class="list-inline ms-auto d-lg-block d-none">
                    <div class="list-inline-item me-3">
                        <!-- Button trigger modal -->
                        <a href="https://maps.app.goo.gl/1ba99qhppgJvPDiC7" target="_blank"
                           rel="nofollow, noreferrer, noindex" class="text-reset d-none d-lg-block">
                            <i class="feather-icon icon-map-pin me-2"></i>
                            View Location
                        </a>
                    </div>

                    <div class="list-inline-item me-3">
                        <a href="tel:9979656575" class="text-reset d-none d-lg-block">
                            <i class="feather-icon icon-phone-call me-2"></i>
                            Chirag Bhanderi - 99796 56575
                        </a>
                    </div>

                    <div class="list-inline-item me-3">
                        <a href="tel:9879400857" class="text-reset d-none d-lg-block">
                            <i class="feather-icon icon-phone-call me-2"></i>
                            Shailesh Nasit - 98794 00857
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-light navbar-default py-0 py-lg-2 border-top navbar-offcanvas-color"
     aria-label="Offcanvas navbar large">
    <div class="container d-block d-md-none d-lg-none d-xl-none d-xxl-none">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="navbar-default" aria-labelledby="navbar-defaultLabel">
            <div class="offcanvas-header pb-1">
                <a href="{{ route('home') }}"><img height="80px" src="{{ getPath('common') }}/images/logo.png"
                                                   alt="{{ getConstant('SITE_NAME') }}"/></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item">
                            <a href="https://maps.app.goo.gl/1ba99qhppgJvPDiC7" target="_blank"
                               rel="nofollow, noreferrer, noindex" class="nav-link">
                                <i class="feather-icon icon-map-pin me-2"></i>
                                View Location
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="tel:9979656575" class="nav-link">
                                <i class="feather-icon icon-phone-call me-2"></i>
                                Chirag Bhanderi - 99796 56575
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="tel:9879400857" class="nav-link">
                                <i class="feather-icon icon-phone-call me-2"></i>
                                Shailesh Nasit - 98794 00857
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>