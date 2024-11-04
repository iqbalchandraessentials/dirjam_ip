<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header nav-small-cap text-uppercase">Approval List</li>
                <li class="pt-3 {{ Request::is('approval_list') ? 'active' : '' }}">
                    <a href="{{ url('approval_list') }}">
                        <i class="ti-clipboard"></i>
                        <span>Approval List</span>
                    </a>
                </li>
            
                <li class="header nav-small-cap text-uppercase">Job Description</li>
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ url('home') }}">
                        <i class="ti-home"></i>
                        <span>Home</span>
                    </a>
                </li>
            
                <li class="{{ Request::is('uraian_jabatan') ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-settings"></i>
                        <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === null || Request::segment(2) === 'add-new' ? 'active' : '' }}">
                            <a href="{{ url('/facilities') }}">
                                <i class="ti-more"></i>List Facilities
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === 'categories' ? 'active' : '' }}">
                            <a href="{{ url('/facilities/categories') }}">
                                <i class="ti-more"></i>Categories
                            </a>
                        </li>
                    </ul>
                </li>
            
                <li class="{{ Request::is('revisi_uraian_jabatan') ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-medall-alt"></i>
                        <span>Kompetensi</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === null || Request::segment(2) === 'add-new' ? 'active' : '' }}">
                            <a href="{{ url('/facilities') }}">
                                <i class="ti-more"></i>List Facilities
                            </a>
                        </li>
                        <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === 'categories' ? 'active' : '' }}">
                            <a href="{{ url('/facilities/categories') }}">
                                <i class="ti-more"></i>Categories
                            </a>
                        </li>
                    </ul>
                </li>            
                <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                    <a href="{{ url('faq') }}">
                        <i class="ti-medall"></i>
                        <span>Uraian Jabatan</span>
                    </a>
                </li>

            <li class="header nav-small-cap text-uppercase">Others</li>
            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                <a href="{{ url('faq') }}">
                    <i class="ti-clipboard"></i>
                    <span>Template</span>
                </a>
            </li>
            <li class="{{ Request::is('revisi_uraian_jabatan') ? 'active' : '' }}">
                <a href="#">
                    <i class="ti-calendar"></i>
                    <span>Loader</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === null || Request::segment(2) === 'add-new' ? 'active' : '' }}">
                        <a href="{{ url('/facilities') }}">
                            <i class="ti-more"></i>List Facilities
                        </a>
                    </li>
                    <li class="{{ Request::segment(1) === 'facilities' && Request::segment(2) === 'categories' ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Categories
                        </a>
                    </li>
                </ul>
            </li>  
            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                <a href="{{ url('faq') }}">
                    <i class="ti-help-alt"></i>
                    <span>FAQs</span>
                </a>
            </li>
            
            
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti-power-off"></i>
                    <span>Log Out</span>
                </a>
            </li>
    </section>
</aside>