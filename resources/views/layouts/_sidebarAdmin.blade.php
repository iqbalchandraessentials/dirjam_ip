<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            {{-- <li class="header nav-small-cap text-uppercase">Approval List</li> --}}
            <li class="pt-3 {{ Request::is('approval_list') ? 'active' : '' }}">
                <a href="{{ route('approval_list') }}">
                    <i class="ti-clipboard"></i>
                    <span>Approval List</span>
                </a>
            </li>
        
            {{-- <li class="header nav-small-cap text-uppercase">Job Description</li> --}}
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="ti-home"></i>
                    <span>Home</span>
                </a>
            </li>
        
            <li class="treeview {{ Request::segment(1) === 'facilities' ? 'active' : '' }}">
                <a href="#">
                    <i class="ti-settings"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('roles') || Request::is('facilities/create') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="ti-more"></i>Hak Akses
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities') || Request::is('facilities/add-new') ? 'active' : '' }}">
                        <a href="{{ route('permissions.index') }}">
                            <i class="ti-more"></i>Permission
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities') || Request::is('facilities/add-new') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="ti-more"></i>User Index
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Bidang Studi
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Pendidikan
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Jenjang
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Tanggung Jawab Generik
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Indikator
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Unit
                        </a>
                    </li>
                    <li class="{{ Request::is('facilities/categories') ? 'active' : '' }}">
                        <a href="{{ url('/facilities/categories') }}">
                            <i class="ti-more"></i>Periode
                        </a>
                    </li>
                </ul>
            </li>
                    
            <li class="treeview {{ Request::is('revisi_uraian_jabatan') ? 'active' : '' }}">
                <a href="#">
                    <i class="ti-medall-alt"></i>
                    <span>Kompetensi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('revisi_uraian_jabatan/facilities') ? 'active' : '' }}">
                        <a href="{{ url('/revisi_uraian_jabatan/facilities') }}">
                            <i class="ti-more"></i>Evaluasi Kompetensi
                        </a>
                    </li>
                    <li class="{{ Request::is('revisi_uraian_jabatan/job-profession') ? 'active' : '' }}">
                        <a href="{{ url('/revisi_uraian_jabatan/job-profession') }}">
                            <i class="ti-more"></i>Jabatan - Profesi
                        </a>
                    </li>
                    <li class="{{ Request::is('revisi_uraian_jabatan/profession-competency') ? 'active' : '' }}">
                        <a href="{{ url('/revisi_uraian_jabatan/profession-competency') }}">
                            <i class="ti-more"></i>Profesi - Kompetensi
                        </a>
                    </li>
                </ul>
            </li>

        
            <li class="{{ Request::is('uraian_jabatan') ? 'active' : '' }}">
                <a href="{{ url('uraian_jabatan') }}">
                    <i class="ti-medall"></i>
                    <span>Uraian Jabatan</span>
                </a>
            </li>
        
            {{-- <li class="header nav-small-cap text-uppercase">Others</li> --}}
            <li class="{{ Request::is('template') ? 'active' : '' }}">
                <a href="{{ url('template') }}">
                    <i class="ti-clipboard"></i>
                    <span>Template</span>
                </a>
            </li>
        
            <li class="treeview {{ Request::is('loader') ? 'active' : '' }}">
                <a href="#">
                    <i class="ti-calendar"></i>
                    <span>Loader</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('loader/facilities') ? 'active' : '' }}">
                        <a href="{{ url('/loader/facilities') }}">
                            <i class="ti-more"></i>Loader Template
                        </a>
                    </li>
                    <li class="{{ Request::is('loader/categories') ? 'active' : '' }}">
                        <a href="{{ url('/loader/categories') }}">
                            <i class="ti-more"></i>Loader Uraian Jabatan
                        </a>
                    </li>
                </ul>
            </li>
        
            <li class="{{ Request::is('faq') ? 'active' : '' }}">
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
        </ul>
        
    </section>
</aside>