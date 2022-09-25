<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="{{route('user.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Requisition</div>
                <a class="nav-link collapsed" href="{{route('user.requisition')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-plus-circle-alt"></i></div>
                    Request Requisition
                </a>
<a class="nav-link collapsed" href="{{route('user.logout')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Logout
                </a>

            </div>
        </div>
    </nav>

</div>
