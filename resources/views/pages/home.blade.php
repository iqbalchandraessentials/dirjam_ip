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
                    <h2 class="box-title">
                        
                            <i class="ti-file"></i>
                            Uraian Jabatan
                    </h2>
                </div>
                <div class="col text-right"> 
                    <a href="{{route('uraianJabatan.draft', $data['masterJabatan']['id'])}}" class="btn btn-secondary">
                        <i class="ti-view-list-alt"></i><span>  Draft</span>
                    </a>
                    <a href="{{ route('export.pdf', $data['id']) }}" class="btn btn-primary">
                        <i class="ti-printer"></i><span>  Cetak</span>
                    </a>
                </div>
            </div>
            </div>
                <div class="box-header">
                        <h4 >1. Identitas Jabatan</h4>
                        <p class="font-italic">
                            Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu
                            organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi
                            jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut
                            dijalankan.
                        </p>
                    </div>
                    <div class="box-body">
                            <div class="table-resposive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td><b> Master Jabatan</b></td>
                                            <td>:</td>
                                            <td class="text-left">{{ $data['nama'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><b> Sebutan Jabatan</b></td>
                                            <td>:</td>
                                            <td class="text-left"> - </td>
                                        </tr>
                                        <tr>
                                            <td><b> Jenis Jabatan</b></td>
                                            <td>:</td>
                                            <td class="text-left"> {{ $data['MasterJabatan']['jenis_jabatan'] }} </td>
                                        </tr>
                                        <tr>
                                            <td><b> Jenjang Jabatan</b></td>
                                            <td>:</td>
                                            <td class="text-left"> {{$data['MasterJabatan']['jenjang_kode']}} </td>
                                        </tr>
                                        <tr>
                                            <td><b> Kelompok Bisnis</b></td>
                                            <td>:</td>
                                            <td class="text-left"> - </td>
                                        </tr>
                                        <tr>
                                            <td><b> Stream Bisnis</b></td>
                                            <td>:</td>
                                            <td class="text-left"> - </td>
                                        </tr>
                                        <tr>
                                            <td><b> Unit Kerja</b></td>
                                            <td>:</td>
                                            <td class="text-left">{{$data['masterJabatan']['unit_kode']}}</td>
                                        </tr>
                                        <tr>
                                            <td><b> Jabatan Atasan Langsung</b></td>
                                            <td>:</td>
                                            <td class="text-left">-</td>
                                        </tr>
        
                                    </thead>
                                </table>
                            </div>
                        
                    </div>
                
            </div>
        
        <div class="box">
            <div class="box-header">
                <h4 class="box-title">2. Tujuan Jabatan</h4>
                <div class="mt-4">
                    <p class="font-italic">
                        Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu
                        organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi
                        jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut
                        dijalankan.
                    </p>
                </div>
                <div class="col-sm-12 col-12">
                    <p class="blockquote">
                        {{ $data->fungsi_utama }}
                    </p>
                </div>

            </div>
        </div>

    

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">3. TUGAS POKOK UTAMA DAN OUTPUT</h4>
                <div class="mt-4">
                    <p class="font-italic">
                        Merupakan deskripsi yang spesifik tentang pekerjaan guna tercapainya tujuan jabatan, yang dilengkapi
                        dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan atau dokumentasi dalam
                        bentuk lain yang dapat dipertanggungjawabkan hasilnya.
                    </p>
                </div>
            </div>
            <div class="box-body">

                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left font-weight-bold" width="5%">#</th>
                                    <th class="text-left font-weight-bold" width="60%">Aktivitas</th>
                                    <th class="text-left font-weight-bold" width="35%">Output</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->tugasPokoUtamaGenerik as $x => $v)
                                    @if ($v['jenis'] == 'utama')
                                        <tr>
                                            <td> <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $x + 1 }}</span></td>
                                            <td>{{ $v['aktivitas'] }}</td>
                                            <td>{{ $v['output'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-header">
                <h4 class="box-title">4. TUGAS POKOK GENERIK DAN OUTPUT</h4>
                <div class="mt-5">
                    <p class="font-italic">
                        Merupakan rincian aktivitas-aktivitas umum yang diperlukan suatu jabatan sesuai jenis jabatan
                        tersebut, yang dilengkapi dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan
                        atau dokumentasi dalam bentuk lain yang dapat dipertanggungjawabkan hasilnya.
                    </p>
                </div>
                <div class="box-body">

                    <div class="form-group mb-0">
                        <div class="table-resposive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-left font-weight-bold" width="5%">#</th>
                                        <th class="text-left font-weight-bold" width="60%">Aktivitas</th>
                                        <th class="text-left font-weight-bold" width="35%">Output</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tugaspokokGenerik as $x => $v)
                                        @if ($v['jenis'] == 'generik')
                                            <tr>
                                                <td><span class="badge bg-dark"
                                                        style="min-width: 32px">{{ $x + 1 }}</span></td>
                                                <td>{{ $v['aktivitas'] }}</td>
                                                <td>{{ $v['output'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-12 text-left">
                        <h4 class="box-title">5. Dimensi Jabatan</h4>
                        <div class="mt-5">
                            <p class="font-italic">
                                Memuat semua data relevan yang dapat diukur dan digunakan untuk menggambarkan cakupan
                                atau besarnya tanggung jawab yang dipegang termasuk ringkasan data kuantitatif dan
                                kualitatif yang etrkait dengan besarnya tugas ini.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <div class="box-body pt-0 pb-0">
                    <p><b>5.a. Dimensi Finansial</b></p>
                    <div class="table-resposive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anggaran</td>
                                    <td>{{ $data['anggaran'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Accountability</td>
                                    <td>{{ $data['accountability'] }}</td>
                                </tr>
                                <tr>
                                    <td>Nature Impact</td>
                                    <td>{{ $data['nature_impact'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box-body pt-0 pb-0">
                    <p><b>5.b. Dimensi Non-keuangan</b></p>
                    <div class="table-resposive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2"> a. Jumlah staff yang dikelola di sub bidangnya sesuai FTK
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Jumlah Bawahan Langsung
                                    </td>
                                </tr>
                                <tr>
                                    <td>Langsung</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td colspan="2">b. Proses bisnis yang dikelola di sub bidangnya</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">6. Hubungan Kerja</h4>
                <div>
                    <p class="font-italic">
                        Menggambarkan hubungan kedinasan antara pemegang jabatan dengan jabatan lain dalam
                        perusahaan maupun di perusahaan lain, yang disertai dengan deskripsi tujuan dari hubungan
                        kerja tersebut.
                    </p>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5%">#</th>
                                    <th class="text-center font-weight-bold">Komunikasi Internal</th>
                                    <th class="text-center font-weight-bold">Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($data['hubunganKerja'] as $x => $v)
                                    @if ($v['jenis'] == 'internal')
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $no++ }}</span>
                                            </td>
                                            <td>{{ $v['komunikasi'] }}</td>
                                            <td>{{ $v['tujuan'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-center" width="5%">#</th>
                                    <th class="font-weight-bold text-center">Komunikasi Eksternal
                                    </th>
                                    <th class="font-weight-bold text-center">Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($data['hubunganKerja'] as $x => $v)
                                    @if ($v['jenis'] == 'eksternal')
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $no++ }}</span>
                                            </td>

                                            <td>{{ $v['komunikasi'] }}</td>
                                            <td>{{ $v['tujuan'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">7. MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA</h4>
                <div>
                    <p class="font-italic">
                        Merupakan uraian atas hal-hal yang menjadi permasalahan bagi pemangku jabatan sebagai akibat dari
                        adanya kesulitan dalam pencapaian tujuan atau target yang ditetapkan.
                    </p>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-center" width="5%">#</th>
                                    <th class="font-weight-bold text-center">MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($masalahKompleksitasKerja as $x => $v)
                                    <tr>
                                        <td> <span class="badge bg-dark"
                                                style="min-width: 32px">{{ $x + 1 }}</span></td>
                                        <td>{{ $v['definisi'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">8. WEWENANG JABATAN</h4>
                <div>
                    <p class="font-italic">
                        Menjelaskan sejauh mana peran jabatan ini dalam pengambilan keputusan dan dampak apa yang dapat
                        ditimbulkan dari keputusan yang diambilnya.
                    </p>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-center" width="5%">#</th>
                                    <th class="font-weight-bold text-center">WEWENANG JABATAN</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                @foreach ($wewenangJabatan as $x => $v)
                                    <tr>
                                        <td> <span class="badge bg-dark"
                                                style="min-width: 32px">{{ $x + 1 }}</span></td>
                                        <td>{{ $v['definisi'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">9. SPESIFIKASI JABATAN</h4>
                <div>
                    <p class="font-italic">
                        Menguraikan dan menjelaskan pendidikan, pengetahuan pokok, keterampilan dan pengalaman minimal serta
                        kompetensi yang diperlukan untuk mencapai tujuan jabatan, yang terdiri atas kualifikasi jabatan,
                        kemampuan dan pengalaman, dan kompetensi.
                    </p>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="table-resposive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-center" width="5%">#</th>
                                    <th class="font-weight-bold text-center">Pendidikan</th>
                                    <th class="font-weight-bold text-center">Pengalaman</th>
                                    <th class="font-weight-bold text-center" width="30%">Bidang Studi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($data['spesifikasiPendidikan'] as $x => $v)
                                    <tr>
                                        <td> <span class="badge bg-dark"
                                                style="min-width: 32px">{{ $x + 1 }}</span></td>
                                        <td>{{ $v['pendidikan'] }}</td>
                                        <td>{{ $v['pengalaman'] }}</td>
                                        <td>
                                            @php
                                                $pattern = '/\d+\.\s*/'; // Pola untuk memisahkan berdasarkan angka diikuti titik dan spasi
                                                $bidangStudiList = preg_split($pattern, $v['bidang_studi'], -1, PREG_SPLIT_NO_EMPTY);

                                                foreach ($bidangStudiList as $index => $bidangStudi) {
                                                    echo ($index + 1) . '. ' . trim($bidangStudi) . '<br>';
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-body">
                <h4><b> Kemampuan dan Pengalaman</b></h4>
                <div class="table-resposive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                        </thead>
                        <tbody>
                            <ol type="a">
                                @foreach ($kemampuandanPengalaman as $x)
                                    <li> {{ $x['definisi'] }}</li>
                                @endforeach
                            </ol>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-12 text-left">
                        <h3 class="box-title">9. STRUKTUR ORGANISASI</h3>
                        <div>
                            <p class="font-italic">
                                Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi
                                jabatan atasan langsung, bawahan langsung serta rekan kerja (peers).
                            </p>

                        </div>
                    </div>
                </div>
                <div class="box-body pt-0 pb-0">
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h4 class="box-title">11. KEBUTUHAN KOMPETENSI JABATAN (KKJ)</h4>
                <div>
                    <p class="font-italic">
                        Memberikan informasi mengenai kebutuhan kemahiran/kompetensi yang diharapkan dalam suatu jabatan.
                    </p>
                </div>
            </div>
            
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="p-5">
                        <h4> <b>>> Kompetensi Utama</b></h4>
                        <p class="font-italic">Kompetensi perilaku yang harus dimiliki oleh seluruh individu Pegawai dalam organisasi, pada semua fungsi dan Jenjang Jabatan.</p>
                    </div>
                    <div class="table-resposive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5%">#</th>
                                    <th class="text-center font-weight-bold">Kode Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kompetensi</th>
                                    <th class="text-center font-weight-bold">Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($data['keterampilanNonteknis'] as $x => $v)
                                    @if ($v['kategori'] == 'UTAMA')
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $no++ }}</span>
                                            </td>
                                            <td>{{ $v['kode'] }}</td>
                                            <td>{{ $v['detail']['nama'] ?? '' }}</td>
                                            <td>{{ $v['detail']['definisi'] ?? '' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="p-5">
                        <h4><b>>> Kompetensi Peran</b></h4>
                        <p class="font-italic">Kompetensi perilaku yang dipersyaratkan agar individu Pegawai dapat berhasil dalam suatu posisi, peran, dan Jenjang Jabatan yang spesifik.</p>
                    </div>
                    <div class="table-resposive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5%">#</th>
                                    <th class="text-center font-weight-bold">Kode Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kategori</th>
                                    <th class="text-center font-weight-bold">Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($data['keterampilanNonteknis'] as $v)
                                    @if ($v['kategori'] == 'PERAN')
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark" style="min-width: 32px">{{ $no++ }}</span>
                                            </td>
                                            <td>{{ $v['kode'] }}</td>
                                            <td>{{ $v['detail']['nama'] }}</td>
                                            <td class="text-uppercase">{{ $v['jenis'] }}</td>
                                            <td>{{ $v['detail']['definisi'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="p-5">
                        <h4><b>>> Kompetensi Fungsi</b></h4>
                        <p class="font-italic">Kompetensi perilaku yang harus dimiliki untuk setiap fungsi bisnis di dalam organisasi.</p>
                    </div>
                    <div class="table-resposive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5%">#</th>
                                    <th class="text-center font-weight-bold">Kode Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kategori</th>
                                    <th class="text-center font-weight-bold">Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($data['keterampilanNonteknis'] as $x => $v)
                                    @if ($v['kategori'] == 'FUNGSI')
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $no++ }}</span>
                                            </td>
                                            <td>{{ $v['kode'] }}</td>
                                            <td>{{ $v['detail']['nama'] ?? '' }}</td>
                                            <td class="text-uppercase">{{ $v['jenis'] ?? '' }}</td>
                                            <td>{{ $v['detail']['definisi'] ?? '' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
            <div class="box-body">
                <div class="form-group mb-0">
                    <div class="p-5">
                        <h4><b>>> Kompetensi Teknis</b></h4>
                        <p class="font-italic">Kompetensi terkait dengan pengetahuan, keterampilan dan keahlian yang diperlukan sesuai dengan tugas pokok masing-masing individu Pegawai untuk menyelesaikan pekerjaan-pekerjaan secara teknis pada jabatannya.</p>
                    </div>
                    <div class="table-resposive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center font-weight-bold" width="5%">#</th>
                                    <th class="text-center font-weight-bold">Kode Kompetensi</th>
                                    <th class="text-center font-weight-bold">Kompetensi</th>
                                    <th class="text-center font-weight-bold">Level</th>
                                    <th class="text-center font-weight-bold">Kategori</th>
                                    <th class="text-center font-weight-bold">Penjelasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($keterampilanTeknis as $x => $v)
                                        @if (isset($v['master']['nama']))
                                        <tr>
                                            <td>
                                                <span class="badge bg-dark"
                                                    style="min-width: 32px">{{ $no++ }}</span>
                                            </td>
                                            <td>{{ $v['kode'] }}</td>
                                            <td>{{ $v['master']['nama']}}</td>
                                            <td>{{ $v['level'] }}</td>
                                            <td>{{ $v['kategori'] }}</td>
                                            <td>{{ $v->detailMasterKompetensiTeknis->perilaku ?? 'N/A' }}</td>
                                        </tr>
                                        @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
@endsection
