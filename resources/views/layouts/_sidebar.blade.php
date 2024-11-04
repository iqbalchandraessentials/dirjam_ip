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
                        <i class="ti-briefcase"></i>
                        <span>My Job Description</span>
                    </a>
                </li>
            
                <li class="{{ Request::is('uraian_jabatan') ? 'active' : '' }}">
                    <a href="{{ route('uraian_jabatan') }}">
                        <i class="ti-calendar"></i>
                        <span>List Job Description</span>
                    </a>
                </li>
            
                <li class="{{ Request::is('uraian_jabatan_template') ? 'active' : '' }}">
                    <a href="{{ url('uraian_jabatan_template') }}">
                        <i class="ti-pencil-alt"></i>
                        <span>Revisi Job Description</span>
                    </a>
                </li>            

            <li class="header nav-small-cap text-uppercase">Others</li>
            <li class="{{ Request::segment(1) === 'booking-list' ? 'active' : '' }}">
                <a href="{{ url('faq') }}">
                    <i class="ti-menu-alt"></i>
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