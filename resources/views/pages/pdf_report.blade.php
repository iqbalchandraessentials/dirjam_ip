<head>
    <meta charset="utf-8">

    <style>
        * {
            font-family: sans-serif;
            font-size: 10;
            letter-spacing: 0px;
        }

        body {
            font-size: 125%;
            letter-spacing: 0.05em;
            line-height: 1.3em;
        }

        body>* {
            font-size: 85%;
            line-height: 1.3em;
        }

        #table,
        #table th,
        #table td {
            border-collapse: collapse;
            border: 1px #000 solid;

            padding: 3px;
        }

        #table {
            width: 100%;
        }

        #table td {
            vertical-align: top;
        }

        .mini {
            font-size: 10px;
            font-style: italic;
            display: block;
            font-weight: normal;
        }

        @media print {
            .perkecil {
                width: 300px Imp !important;
            }
        }

        ul li {
            list-style-type: none;
        }

        ul li:before {
            content: "-";
            position: relative;
            left: -10px;
        }

        ul li {
            text-indent: -5px;
        }
    </style>
</head>


<table id="table" style="width: 100%">
    <tr>
        <td>

            @php
            $ipImage = base64_encode(file_get_contents(public_path('img/ip.png')));
            $plnImage = base64_encode(file_get_contents(public_path('img/pln.png')));
        @endphp
        
        <table style="width: 100%">
            <tr>
                <td style="text-align: left;border:none; height: 40px">
                    <img src="data:image/png;base64,{{ $ipImage }}" style="float: left; height: 40px" />
                </td>
                <td style="text-align: right;border:none; height: 40px">
                    <img src="data:image/png;base64,{{ $plnImage }}" style="float: right; height: 40px" />
                </td>
            </tr>
        </table>
        
        </td>


    </tr>
    <tr>
        <td>

            <br />
            <span style="font-size: 18px">URAIAN JABATAN - {{ $data['nama'] }}</span><br />

            <br />
            <br />
        </td>


    </tr>


</table>
<br />
<ol style="font-weight: bold">
    <li>
        IDENTITAS JABATAN
        <small class="mini">
            Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu
            organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi
            jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut
            dijalankan.
        </small>

        <div style="font-weight: normal">
            <table>
                <tr>
                    <td>Master Jabatan</td>
                    <td>:</td>
                    <td><?= $data['nama'] ?></td>
                </tr>
                <tr>
                    <td>Sebutan Jabatan</td>
                    <td>:</td>
                    <td><?= '-' ?></td>
                </tr>
                <tr>
                    <td>Jenis Jabatan</td>
                    <td>:</td>
                    <td>
                        <?= $data['jenjang_kode'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Kelompok Bisnis</td>
                    <td>:</td>
                    <td>
                        <?= '-' ?>
                    </td>
                </tr>
                <tr>
                    <td>Stream Bisnis</td>
                    <td>:</td>
                    <td>
                        <?= '-' ?>
                    </td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>:</td>
                    <td>
                        <?= $data['unit_kode'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Jabatan Atasan Langsung</td>
                    <td>:</td>
                    <td>
                        <?= '-' ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </li>
    <li>FUNGSI UTAMA
        <small class="mini">
            Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu
            organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi
            jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut
            dijalankan.
        </small>
        <br>
        <div style="font-weight: normal; text-align: justify; margin-left:3px;">
            <?= nl2br($data->uraianMasterJabatan->fungsi_utama) ?>
            <br />
            <br />

        </div>

    </li>
    <li>TUGAS POKOK UTAMA DAN OUTPUT
        <small class="mini">
            Merupakan deskripsi yang spesifik tentang pekerjaan guna tercapainya tujuan jabatan, yang dilengkapi
            dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan atau dokumentasi dalam
            bentuk lain yang dapat dipertanggungjawabkan hasilnya.
        </small>
        <div style="font-weight: normal">
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="width: 30px;text-align: center">No</th>
                        <th style="width: 400px; text-align: center" class='perkecil'>Aktivitas</th>
                        <th style="text-align: center">Output</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->uraianMasterJabatan->tugasPokoUtamaGenerik as $x => $v)
                        @if ($v['jenis'] == 'utama')
                            <tr>
                                <td> <span class="badge bg-dark" style="min-width: 32px">{{ $x + 1 }}</span></td>
                                <td>{{ $v['aktivitas'] }}</td>
                                <td>{{ $v['output'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>


            </table>

            <br />
            <br />

        </div>

    </li>

    <li>TUGAS POKOK GENERIK DAN OUTPUT
        <small class="mini">
            Merupakan rincian aktivitas-aktivitas umum yang diperlukan suatu jabatan sesuai jenis jabatan
            tersebut, yang dilengkapi dengan informasi yang merujuk hasil kerja dapat berupa dokumen, laporan
            atau dokumentasi dalam bentuk lain yang dapat dipertanggungjawabkan hasilnya.
        </small>
        <div style="font-weight: normal">
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="width: 30px;text-align: center">No</th>
                        <th style="width: 400px; text-align: center" class='perkecil'>Aktivitas</th>
                        <th style="text-align: center">Output</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugaspokokGenerik as $x => $v)
                        @if ($v['jenis'] == 'generik')
                            <tr>
                                <td><span class="badge bg-dark" style="min-width: 32px">{{ $x + 1 }}</span></td>
                                <td>{{ $v['aktivitas'] }}</td>
                                <td>{{ $v['output'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br />
            <br />

        </div>

    </li>

    <li>Dimensi Jabatan
        <small class="mini">
            Memuat semua data relevan yang dapat diukur dan digunakan untuk menggambarkan cakupan
            atau besarnya tanggung jawab yang dipegang termasuk ringkasan data kuantitatif dan
            kualitatif yang etrkait dengan besarnya tugas ini.
        </small>
        <br>
        <ol type="a">
            <li>Dimensi Finansial
                <div style="font-weight: normal;">
                    <table>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['anggaran'] == 'Investasi' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Anggaran Investasi</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['anggaran'] == 'Operasional' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Anggaran Operasional</td>
                        </tr>
                    </table>
                    <b>Accountability</b>
                    <table>    
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Non Quantifiable' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Non Quantifiable</td>
                            <td></td>
                            <td>< 650 Juta</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Very Small' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Very Small</td>
                            <td></td>
                            <td>650 Juta - 6,5 Milyar</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Small' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Small</td>
                            <td></td>
                            <td>6,5 Milyar - 65 Milyar</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Medium' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Medium</td>
                            <td></td>
                            <td>65 Milyar - 650 Milyar</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Large' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Large</td>
                            <td></td>
                            <td>650 Milyar - 6,5 Trilyun</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['accountability'] == 'Very Large' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Very Large</td>
                            <td></td>
                            <td>6,5 Trilyun - 65 Trilyun</td>
                        </tr>      
                    </table>
                    <b>Nature Impact</b>
                    <table>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['nature_impact'] == 'Prime' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Prime</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['nature_impact'] == 'Share' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Share</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['nature_impact'] == 'Contributory' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Contributory</td>
                        </tr>
                        <tr>
                            <td style="width: 20px; text-align: center; border: 1px solid #000;">
                                {{ $data['uraianMasterJabatan']['nature_impact'] == 'Remote' ? 'V' : '' }}
                            </td>
                            <td></td>
                            <td>Remote</td>
                        </tr>
                    </table>
                    <br>
                </div>
            </li>
            <li>Dimensi Non-keuangan
                <br>
                <div style="font-weight: normal;">
                    <table>
                        <tr>
                            <td>
                                a. Jumlah staff yang dikelola di sub bidangnya sesuai FTK
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Jumlah Bawahan Langsung
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Langsung
                            </td>
                            <td>:</td>
                            <td><?= '-' ?></td>
                        </tr>
                        <tr>
                            <td>
                                Total
                            </td>
                            <td>:</td>
                            <td><?= '-' ?></td>
                        </tr>
                        <tr>
                            <td>
                                Langsung
                            </td>
                            <td>:</td>
                            <td><?= '-' ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">b. Proses bisnis yang dikelola di sub bidangnya</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                            <td></td>
                        </tr>
                    </table>
                    <br />
                </div>
            </li>
        </ol>
    </li>

    <li>HUBUNGAN KERJA
        <small class="mini">
            Menggambarkan hubungan kedinasan antara pemegang jabatan dengan jabatan lain dalam
            perusahaan maupun di perusahaan lain, yang disertai dengan deskripsi tujuan dari hubungan
            kerja tersebut.
        </small>
        <div style="font-weight: normal">
            <br>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">

                    <table class="table " id="table">
                        <thead>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th style=" text-align: center">Komunikasi Internal</th>
                                <th style=" text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['uraianMasterJabatan']['hubunganKerja'] as $x => $v)
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
            <br>
            <hr />
            <br>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">

                    <table class="table " id="table">
                        <thead>
                            <tr>
                                <th style="text-align: center">No</th>
                                <th style=" text-align: center">Komunikasi Eksternal</th>
                                <th style=" text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['uraianMasterJabatan']['hubunganKerja'] as $x => $v)
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
        <br />
    </li>

    <li>MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA
        <small class="mini">
            Merupakan uraian atas hal-hal yang menjadi permasalahan bagi pemangku jabatan sebagai akibat dari
                        adanya kesulitan dalam pencapaian tujuan atau target yang ditetapkan.
        </small>
        <div style="font-weight: normal">
            <br>
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center">No</th>
                            <th style=" text-align: center">MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($masalahKompleksitasKerja as $x => $v)
                                    <tr>
                                        <td> <span class="badge bg-dark"
                                                style="min-width: 32px">{{ $x + 1 }}</span></td>
                                        <td>{{ $v['definisi'] }}</td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
            </div>
            
        </div>
        </br>
    </li>

    <li>WEWENANG JABATAN
        <small class="mini">
            Menjelaskan sejauh mana peran jabatan ini dalam pengambilan keputusan dan dampak apa yang dapat
            ditimbulkan dari keputusan yang diambilnya.
        </small>
        <div style="font-weight: normal">
            <br>
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center">No</th>
                            <th style=" text-align: center">WEWENANG JABATAN</th>
                        </tr>
                    </thead>
                    <tbody>
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
        </br>
    </li>

    <li>SPESIFIKASI JABATAN
        <small class="mini">
            Menguraikan dan menjelaskan pendidikan, pengetahuan pokok, keterampilan dan pengalaman minimal serta
            kompetensi yang diperlukan untuk mencapai tujuan jabatan, yang terdiri atas kualifikasi jabatan,
            kemampuan dan pengalaman, dan kompetensi.
        </small>
        <div style="font-weight: normal">
            <br>
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center">No</th>
                            <th style=" text-align: center">Pendidikan</th>
                            <th style=" text-align: center">Pengalaman</th>
                            <th style=" text-align: center">Bidang Studi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['uraianMasterJabatan']['spesifikasiPendidikan'] as $x => $v)
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
            <br>
            <b> Kemampuan dan Pengalaman</b>
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
        </br>
    </li>
    
    <li>STRUKTUR ORGANISASI
        <small class="mini">
            Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan langsung, bawahan langsung serta rekan kerja (peers).
        </small>
        <br>
    </li>
    

    <li>KEBUTUHAN KOMPETENSI JABATAN (KKJ)
        <small class="mini">
            Memberikan informasi mengenai kebutuhan kemahiran/kompetensi yang diharapkan dalam suatu jabatan.
        </small>
        <div style="font-weight: normal">
            <br>
            <b>>> Kompetensi Utama</b>
            <small class="mini">
                Kompetensi perilaku yang harus dimiliki oleh seluruh individu Pegawai dalam organisasi, pada semua fungsi dan Jenjang Jabatan.
            </small>
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center">No</th>
                            <th style="text-align: center">Kode Kompetensi</th>
                            <th style="text-align: center">Kompetensi</th>
                            <th style="text-align: center">Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data['uraianMasterJabatan']['keterampilanNonteknis'] as $x => $v)
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
        <br>
        <div class="form-group" style="font-weight: normal">
            <b>>> Kompetensi Peran</b>
            <small class="mini">
                Kompetensi perilaku yang dipersyaratkan agar individu Pegawai dapat berhasil dalam suatu posisi, peran, dan Jenjang Jabatan yang spesifik.
            </small>
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                            <th style="text-align: center">Kode Kompetensi</th>
                            <th style="text-align: center">Kompetensi</th>
                            <th style="text-align: center">Kategori</th>
                            <th style="text-align: center">Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data['uraianMasterJabatan']['keterampilanNonteknis'] as $x => $v)
                            @if ($v['kategori'] == 'PERAN')
                                <tr>
                                    <td>
                                        <span class="badge bg-dark"
                                            style="min-width: 32px">{{ $no++ }}</span>
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
            <br>
            <b>>> Kompetensi Fungsi</b>
            <small class="mini">
                Kompetensi perilaku yang harus dimiliki untuk setiap fungsi bisnis di dalam organisasi.
            </small>
            <div class="form-group" style="font-weight: normal">
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                            <th style="text-align: center">Kode Kompetensi</th>
                            <th style="text-align: center">Kompetensi</th>
                            <th style="text-align: center">Kategori</th>
                            <th style="text-align: center">Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data['uraianMasterJabatan']['keterampilanNonteknis'] as $x => $v)
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
            <br>
            <b>>> Kompetensi Teknis</b>
            <small class="mini">
                Kompetensi terkait dengan pengetahuan, keterampilan dan keahlian yang diperlukan sesuai dengan tugas pokok masing-masing individu Pegawai untuk menyelesaikan pekerjaan-pekerjaan secara teknis pada jabatannya.
            </small>
            <div class="form-group" style="font-weight: normal">
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                                    <th style="text-align: center">Kode Kompetensi</th>
                                    <th style="text-align: center">Kompetensi</th>
                                    <th style="text-align: center">Level</th>
                                    <th style="text-align: center">Kategori</th>
                                    <th style="text-align: center">Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($KeterampilanTeknis as $x => $v)
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
            <br>
    </li>
    <small style="font-weight: normal">
        - Kompetensi primer adalah Kompetensi yang wajib dimiliki oleh individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.
        <br>
        - Kompetensi sekunder adalah Kompetensi yang perlu dimiliki untuk mendukung individu yang menduduki suatu Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.
        <br>
        - Kompetensi core adalah Kompetensi teknis yang wajib dimiliki berdasarkan tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis
        <br>
        - Kompetensi enabler adalah Kompetensi teknis yang perlu dimiliki untuk mendukung tugas pokok sesuai fungsi utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis.
    </small>
</ol>









{{-- <body>

    <h2>Report Uraian Jabatan</h2>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['position'] }}</td>
                    <td>{{ $item['date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body> --}}
