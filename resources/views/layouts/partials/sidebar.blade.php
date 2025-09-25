<!-- Sidebar untuk desktop -->
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        @include('layouts.partials.sidebar-content')
    </div>
</nav>

<!-- Offcanvas untuk mobile -->
<div class="offcanvas offcanvas-start bg-light" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        @include('layouts.partials.sidebar-content')
    </div>
</div>
