@extends('master')

@section('head')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/sweetalert2.css') }}">
@endsection

@section('title', 'Uraian Jabatan | Direktori Jabatan')

@section('content')
<div class="col-sm-12">

            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="box-title">Identitas Jabatan</h4>
                            <h4 class="box-title">
                                {{-- @if(auth()->user() && auth()->user()->hasRole(['Manager', 'Admin']))
                                    <button class="btn btn-primary">Admin/Manager Actions</button>
                                    @else
                                    taiiii
                                @endif --}}

                            </h4>
                        </div>
                        <div class="col text-right"> <!-- Tambahkan class text-right untuk align ke kanan -->
                            {{-- <a href="{{ route('export.excel') }}" class="btn btn-primary"> --}}
                            <a href="{{ route('export.pdf') }}" class="btn btn-primary">
                                <i class="ti-printer"></i><span> Cetak</span>
                            </a>    
                        </div>
                    </div>
                </div>
                
                <div class="box-body">
                    
                    <div class="form-group mb-0">
                        <div class="table-resposive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-left font-weight-bold" style="width: 40%">Nama Jabatan</th>
                                        <th class="text-left font-weight-bold">Jenjang Jabatan</th>
                                        <th class="text-left font-weight-bold">Unit Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">OFFICER INFORMATION TECHNOLOGY DEVELOPMENT</td>
                                        <td class="text-left text-uppercase">Generalist 2</td>
                                        <td class="text-left">Head Office</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="field_wrapper"></div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                        <div class="form-group">
                            <p class="lead">Fungsi Utama</p>
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-12">
                                    <p class="blockquote">Melakukan analisa dan melaksanakan kegiatan pengembangan terkait sistem informasi termasuk didalamnya sistem IT, framework ISMS (Information Security Management System) untuk memastikan pengembangan sistem informasi perusahaan berdasarkan prinsip GCG (Good Corporate Governance) dan SMAP (Sistem Manajemen Anti Penyuapan).</p>
                                </div>
                            </div>
                        </div>
                        <div id="field_wrapper"></div>
                    </div>
                </div>


                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Tanggung Jawab Utama</h4>
                    </div>
                    <div class="box-body">
                        
                        <div class="form-group mb-0">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-left font-weight-bold" width="5%">#</th>
                                            <th class="text-left font-weight-bold" width="60%">Aktivitas</th>
                                            <th class="text-left font-weight-bold" width="35%">Indikator</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">1</span></td>
                                            <td class="text-left">
                                                <div class="centered">
                                                    Melaksanakan kebijakan fungsi dan standar integrasi dan pengembangan aplikasi sistem TI.
                                                </div>
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%akurasi, %kesesuaian SOP, Laporan)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">2</span></td>
                                            <td class="text-left">
                                                <div class="centered">
                                                    Melaksanakan pengembangan proyek integrasi dan aplikasi sistem TI, memastikan manfaat yang dihasilkan oleh kegiatan aplikasi sistem TI sesuai, efektif dan efisien.
                                                </div>
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%akurasi, %kesesuaian SOP, Laporan)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">3</span></td>
                                            <td class="text-left">
                                                <div class="centered">
                                                    Memberi masukan bidang perencanaan dalam mereview kebutuhan integrasi dan pengembangan aplikasi sistem TI.
                                                </div>
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%akurasi, %kesesuaian SOP, Laporan)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="field_wrapper"></div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Tanggung Jawab Generik</h4>
                    </div>
                    <div class="box-body">
                        
                        <div class="form-group mb-0">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-left font-weight-bold" width="5%">#</th>
                                            <th class="text-left font-weight-bold" width="60%">Aktivitas</th>
                                            <th class="text-left font-weight-bold" width="35%">Indikator</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">1</span></td>
                                            <td class="text-left">
                                                
                                                    Mematuhi dan melaksanakan seluruh program perusahaan yang meliputi, namun tidak terbatas pada manajemen risiko (mulai dari proses identifikasi, analisa, evaluasi, mitigasi risiko, monitoring risiko beserta pelaporannya), manajemen aset, improvement unit kerja (OPI), Lingkungan dan K3 (LK3), 5S, Sistem Manajemen Terpadu (IPIMS) serta program efisiensi energi dan Knowledge Sharing (menyampaikan pengetahuan sesuai kompetensinya melalui metode mengajar/menulis/merekam/metode lainnya) sesuai dengan kewenangannya di unit kerja masing-masing.
                                                
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%kesesuaian SOP, Dokumen, Laporan)</li>
                                                    <li>Kualitas (Persen)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">2</span></td>
                                            <td class="text-left">
                                                <div class="centered">
                                                    Mematuhi seluruh ketentuan Kebijakan Anti Penyuapan dan Kebijakan terkait Penyuapan lainnya (Kebijakan Pengendalian Gratifikasi, Kebijakan Whistleblower, Kebijakan Benturan Kepentingan, Kebijakan Indonesia Power Bersih, Kode Etik, Kebijakan Keterbukaan Informasi Publik, dan Kebijakan Good Corporate Governance), menjalankan tanggung jawab pekerjaan dan tugas secara etis, jujur, rajin dan selalu waspada serta siap melaporkan setiap kasus dugaan suap dengan segera, serta berpartisipasi aktif dalam pelatihan Anti Penyuapan sesuai yang dipersyaratkan dalam peran dan tanggung jawab jabatannya.
                                                </div>
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%kesesuaian SOP, Dokumen, Laporan)</li>
                                                    <li>Kualitas (Persen)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">3</span></td>
                                            <td class="text-left">
                                                <div class="centered">
                                                    Melakukan pelaporan kegiatan fungsi kerja yang menjadi tanggung jawabnya dengan menyusun laporan rutin dan non rutin yang diatur oleh Perusahaan baik secara manual maupun pada aplikasi korporat (ERP, ERM, CSA-ICoFR dan sebagainya) untuk menjamin ketersediaan informasi terkait kegiatan kerja dan fungsinya.
                                                </div>
                                            </td>
                                                    <td class="text-left ">
                                                <ol>
                                                    <li>Kuantitas (%kesesuaian SOP, Dokumen, Laporan)</li>
                                                    <li>Kualitas (Persen)</li>
                                                    <li>Waktu (Bulanan, Semester, Triwulan)</li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="field_wrapper"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <h4 class="box-title">Dimensi Pertanggungjawaban</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body pt-0 pb-0">
                                <div class="table-resposive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jumlah Bawahan Langsung Total</td>
                                                <td>10 orang</td>
                                            </tr>
                                            <tr>
                                                <td>Kewenangan Pengadaan</td>
                                                <td>Tidak Memiliki Wewenang Pengadaan</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Anggaran Maksimal</td>
                                                <td>≤ 500 juta</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="box">
                            <div class="box-header">
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <h4 class="box-title">Persyaratan Jabatan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body pt-0 pb-0">
                                <div class="table-resposive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Kompetensi Utama</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Kompetensi Peran</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Kompetensi Bidang</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>Pendidikan dan Pengalaman</td>
                                                <td>
                                                    <ol>
                                                        <li>S2 jurusan Teknik Informatika pengalaman minimal FG tahun, Pengembangan aplikasi</li>
                                                        <li>S1 jurusan Teknik Informatika pengalaman minimal 1.5 tahun, Pengembangan aplikasi</li>
                                                        <li>D3 jurusan Teknik Informatika pengalaman minimal 3 tahun, Pengembangan aplikasi</li>
                                                        <li>SMK/STM jurusan Teknik Informatika pengalaman minimal 6 tahun, Pengembangan aplikasi</li>
                                                    </ol>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">Karakteristik Jabatan</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group mb-0">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-weight-bold" width="5%">#</th>
                                            <th class="text-center font-weight-bold" >Komunikasi Internal (Ruang Lingkup IP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">1</span></td>
                                            <td class="text-center">
                                                    Melakukan komunikasi dengan User di Kantor Pusat dan Unit dalam rangka Pelayanan IT dalam proses pengembangan aplikasi sistem informasi.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-header">
                            <h4 class="box-title">Tantangan Jabatan</h4>
                        </div>
                        <div class="form-group mb-0">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-weight-bold" width="5%">#</th>
                                            <th class="text-center font-weight-bold" >Komunikasi Eksternal (Ruang Lingkup Eksternal IP)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">1</span></td>
                                            <td class="text-center">
                                                    Melakukan komunikasi dengan User di Kantor Pusat dan Unit dalam rangka Pelayanan IT dalam proses pengembangan aplikasi sistem informasi.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center font-weight-bold" width="5%">#</th>
                                            <th class="text-center font-weight-bold" >Jenis Tantangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-dark" style="min-width: 32px">1</span></td>
                                            <td class="text-center">
                                                    IT audit & IT Security.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="field_wrapper"></div>
                    </div>
                </div>
            </div>
    @endsection
