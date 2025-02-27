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
            {{-- @if(auth()->user()->hasRole('SuperAdmin')) --}}
                <li class="treeview {{ Request::segment(1) === 'master_data' ? 'active' : '' }}">
                    <a href="#">
                        <i class="ti-settings"></i>
                        <span>Master Data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Request::is('master_data/jabatan') ? 'active' : '' }}">
                            <a href="{{ route('master.jabatan') }}">
                                <i class="ti-more"></i>Master Jabatan
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/stoJobcode') ? 'active' : '' }}">
                            <a href="{{ route('master.stoJobcode') }}">
                                <i class="ti-more"></i>STO Jobcode
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/kompetensi-teknis', 'master_data/mapping-komptensi-teknis', 'master_data/kompetensi-teknis/*') ? 'active' : '' }}">
                            <a href="{{ route('master.kompetensi-teknis') }}">
                                <i class="ti-more"></i>Kompetensi Teknis
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/kompetensi-non-teknis', 'master_data/mapping-komptensi-non-teknis') ? 'active' : '' }}">
                            <a href="{{ route('master.kompetensi-non-teknis') }}">
                                <i class="ti-more"></i>Kompetensi Non Teknis
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/tugas-pokok-generik') ? 'active' : '' }}">
                            <a href="{{ route('master.tugas_pokok_generik.index') }}">
                                <i class="ti-more"></i>Tugas Pokok Generik
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/default-master-data') ? 'active' : '' }}">
                            <a href="{{ route('master.defaultData') }}">
                                <i class="ti-more"></i>Default Master Data
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/pendidikan') ? 'active' : '' }}">
                            <a href="{{ route('master.pendidikan') }}">
                                <i class="ti-more"></i>Pendidikan
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/bidang-studi') ? 'active' : '' }}">
                            <a href="{{ route('master.bidangStudi') }}">
                                <i class="ti-more"></i>Bidang Studi
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/jenjang-jabatan') ? 'active' : '' }}">
                            <a href="{{ route('master.jenjang-jabatan') }}">
                                <i class="ti-more"></i>Jenjang Jabatan
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/nature-of-impact' ,'master_data/nature-of-impact/*') ? 'active' : '' }}">
                            <a href="{{ route('master.natureOfImpact') }}">
                                <i class="ti-more"></i>Dimensi Finansial
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/unit') ? 'active' : '' }}">
                            <a href="{{ route('master.unit') }}">
                                <i class="ti-more"></i>Unit
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/indikator') ? 'active' : '' }}">
                            <a href="{{ route('master.indikator') }}">
                                <i class="ti-more"></i>Output Indikator
                            </a>
                        </li>
                        <li class="{{ Request::is('master_data/users', 'master_data/roles') ? 'active' : '' }}">
                            <a href="{{ url('master_data/users') }}">
                                <i class="ti-more"></i>Hak Akses
                            </a>
                        </li>
                    </ul>
                </li>
            {{-- @endif --}}
            <li class="{{ Request::is('template-jabatan/*','template-jabatan', 'template-draft/*') ? 'active' : '' }}">
                <a href="{{ route('template_jabatan.index') }}">
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