<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">
        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            {{-- <li class="header nav-small-cap text-uppercase">Approval List</li> --}}
            {{-- <li class="pt-3 {{ Request::is('approval_list') ? 'active' : '' }}">
                <a href="{{ route('approval_list') }}">
                    <i class="ti-clipboard"></i>
                    <span>Approval List</span>
                </a>
            </li> --}}
        
            {{-- <li class="header nav-small-cap text-uppercase">Job Description</li> --}}
            <li class="{{ Request::is('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">
                    <i class="ti-home"></i>
                    <span>Home</span>
                </a>
            </li>
        
            <li class="treeview {{ Request::segment(1) === 'master_data' ? 'active' : '' }}">
                <a href="#">
                    <i class="ti-settings"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    {{-- <li class="{{ Request::is('master_data/mappingkomptensiTeknis') ? 'active' : '' }}">
                        <a href="{{ route('master.mappingkomptensiTeknis') }}">
                            <i class="ti-more"></i>Mapping Kompetensi Teknis
                        </a>
                    </li> --}}
                    <li class="{{ Request::is('master_data/masterJabatan') ? 'active' : '' }}">
                        <a href="{{ route('master.masterJabatan') }}">
                            <i class="ti-more"></i>Master Jabatan
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/komptensiTeknis', 'master_data/mappingkomptensiTeknis', 'master_data/komptensiTeknis/*') ? 'active' : '' }}">
                        <a href="{{ route('master.masterKompetensiTeknis') }}">
                            <i class="ti-more"></i>Kompetensi Teknis
                        </a>
                    </li>
                    {{-- <li class="{{ Request::is('master_data/mappingkomptensiNonTeknis') ? 'active' : '' }}">
                        <a href="{{ route('master.mappingkomptensiNonTeknis') }}">
                            <i class="ti-more"></i>Mapping Kompetensi Non Teknis
                        </a>
                    </li> --}}
                    <li class="{{ Request::is('master_data/komptensiNonTeknis', 'master_data/mappingkomptensiNonTeknis') ? 'active' : '' }}">
                        <a href="{{ route('master.masterKompetensiNonTeknis') }}">
                            <i class="ti-more"></i>Kompetensi Non Teknis
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/tugasPokokGenerik') ? 'active' : '' }}">
                        <a href="{{ route('master.tugasPokokGenerik') }}">
                            <i class="ti-more"></i>Tugas Pokok Generik
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/defaultMasterData') ? 'active' : '' }}">
                        <a href="{{ route('master.defaultMasterData') }}">
                            <i class="ti-more"></i>Default Master Data
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/pendidikan') ? 'active' : '' }}">
                        <a href="{{ route('master.pendidikan') }}">
                            <i class="ti-more"></i>Pendidikan
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/jenjangJabatan') ? 'active' : '' }}">
                        <a href="{{ route('master.jenjangJabatan') }}">
                            <i class="ti-more"></i>Jenjang Jabatan
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/unit') ? 'active' : '' }}">
                        <a href="{{ route('master.unit') }}">
                            <i class="ti-more"></i>Unit
                        </a>
                    </li>
                    <li class="{{ Request::is('master_data/indikator') ? 'active' : '' }}">
                        <a href="{{ route('master.indikator') }}">
                            <i class="ti-more"></i>Indikator
                        </a>
                    </li>
                    {{-- <li class="{{ Request::is('roles') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="ti-more"></i>Hak Akses
                        </a>
                    </li> --}}
                    {{-- <li class="{{ Request::is('permissions') ? 'active' : '' }}">
                        <a href="{{ route('permissions.index') }}">
                            <i class="ti-more"></i>Permission
                        </a>
                    </li> --}}
                    <li class="{{ Request::is('master_data/users') ? 'active' : '' }}">
                        <a href="{{ url('master_data/users') }}">
                            <i class="ti-more"></i>User Manajemen
                        </a>
                    </li>
                </ul>
            </li>
            
                    
            {{-- <li class="treeview {{ Request::is('revisi_uraian_jabatan') ? 'active' : '' }}">
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
            </li> --}}
            {{-- <li class="header nav-small-cap text-uppercase">Others</li> --}}
            <li class="{{ Request::is('template_jabatan/*','template_jabatan') ? 'active' : '' }}">
                <a href="{{ url('template_jabatan') }}">
                    <i class="ti-medall"></i>
                    <span>Template Jabatan</span>
                </a>
            </li>

            <li class="{{ Request::is(['uraian_jabatan/*', 'uraian_jabatan', 'filter-uraian_jabatan']) ? 'active' : '' }}">
                <a href="{{ url('uraian_jabatan') }}">
                    <i class="ti-clipboard"></i>
                    <span>Uraian Jabatan</span>
                </a>
            </li>       
        
            {{-- <li class="treeview {{ Request::is('loader') ? 'active' : '' }}">
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
            </li> --}}
        
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