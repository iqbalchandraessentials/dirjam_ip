<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header nav-small-cap text-uppercase">Approval list</li>
            <li class="pt-3 {{ Request::segment(1) === 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i class="ti-dashboard"></i>
                    <span>Approval list</span>
                </a>
            </li>
            <li class="header nav-small-cap text-uppercase">Job Description</li>
            <li class="treeview {{ Request::segment(1) === 'meeting-room' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i class="ti-dashboard"></i>
                    <span>My Job Description</span>
                </a>
                <a href="{{ url('dashboard') }}">
                    <i class="ti-dashboard"></i>
                    <span>List Job Description</span>
                </a>
            </li>          
            
            <li class="treeview {{ Request::segment(1) === 'foodandbaverages' && Request::segment(2) === 'menu' || Request::segment(2) === 'categories' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i class="ti-dashboard"></i>
                    <span>Revisi Job Description</span>
                </a>
            </li>

            <li class="header nav-small-cap text-uppercase">Others</li>
            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                <a href="{{ url('booking-list') }}">
                    <i class="ti-clipboard"></i>
                    <span>FAQs</span>
                </a>
            </li>
                        <li>
                <a href="{{ url('') }}">
                    <i class="ti-power-off"></i>
                    <span>Log Out</span>
                </a>
            </li>
    </section>
</aside>