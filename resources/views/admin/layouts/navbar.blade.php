<div class="d-flex">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <h2> Nuaratan </h2>
                <img src="{{ asset('admin_assets/assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
            </span>
            <span class="logo-lg">
                <h1> Nuaratan </h1>
                <img src="{{ asset('admin_assets/assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
            </span>
        </a>

        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <p> Nuaratan </p>
            </span>
            <span class="logo-lg">
                <p> Nuaratan </p>
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
        <i class="ri-menu-2-line align-middle"></i>
    </button>

    <!-- App Search-->
    <form class="app-search d-none d-lg-block">
        <div class="position-relative">
            <input type="text" class="form-control" placeholder="Search...">
            <span class="ri-search-line"></span>
        </div>
    </form>

</div>

<div class="d-flex">

    <div class="dropdown d-inline-block d-lg-none ms-2">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-search-line"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

            <form class="p-3">
                <div class="mb-3 m-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <div class="dropdown d-none d-lg-inline-block ms-1">
        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
            <i class="ri-fullscreen-line"></i>
        </button>
    </div>


    <div class="dropdown d-inline-block user-dropdown">
        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="rounded-circle header-profile-user"
                src="{{ asset('admin_assets/assets/images/users/avatar-2.jpg') }}" alt="Header Avatar">
            <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <div class="dropdown-divider" style="margin-top: -7px"></div>
            <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i
                    class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
        </div>
    </div>


</div>
</div>
</header>
