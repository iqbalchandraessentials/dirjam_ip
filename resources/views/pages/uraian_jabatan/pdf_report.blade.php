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
            text-align: justify;
        }

        #table td {
            vertical-align: top;
        }

        .mini {
            font-size: 10px;
            font-style: italic;
            display: block;
            font-weight: normal;
            text-align: justify;
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
        <td colspan="3">
            <table style="width: 100%">
                <tr>
                    @php
                        $ipImage = base64_encode(file_get_contents(public_path('img/ip.png')));
                        $plnImage = base64_encode(file_get_contents(public_path('img/pln.png')));
                    @endphp
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
        <th style="" rowspan="4">
            <br />
            <span style="font-size: 18px;">URAIAN JABATAN - {{ strtoupper($data['jabatan']->description)}}</span><br />
            <span style="font-size: 16px"><?= $data['jabatan']['jabatan'] ?></span>
            <br />
            <br />
        </th>
        <td style="width:110px">Tanggal</td>
        <td style="width:140px">-</td>
    </tr>
    <tr>
        <td>No Record</td>
        <td><?= '-' ?></td>
    </tr>
    <tr>
        <td>Revisi</td>
        <td><?= '-' ?></td>
    </tr>
    <tr>
        <td>Status</td>
        <td><?= 'SUDAH DI VALIDASI' ?></td>
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
                    <td>{{ $data['jabatan']['master_jabatan'] }}</td>
                </tr>
                <tr>
                    <td>Sebutan Jabatan</td>
                    <td>:</td>
                    <td>
                     {{$data['jabatan']['jabatan']}}
                    </td>
                </tr>
                <tr>
                    <td>Jenis Jabatan</td>
                    <td>:</td>
                    <td>
                        <?= $data['jabatan']['jen'] == "S" ? "STRUKTURAL" : 'FUNSIIONAL' ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenjang Jabatan</td>
                    <td>:</td>
                    <td>
                        <?=  strtoupper($data['jabatan']['nama_profesi']) ?>
                    </td>
                </tr>
                <tr>
                    <td>Divisi/Departemen/Bidang/Bagian</td>
                    <td>:</td>
                    <td>
                        {{$data['jabatan']->divisi}}
                    </td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>:</td>
                    <td>
                        {{ strtoupper($data['jabatan']->description) }}
                    </td>
                </tr>
                <tr>
                    <td>Jabatan Atasan Langsung</td>
                    <td>:</td>
                    <td>
                        {{$data['jabatan']['atasan_langsung']}}
                    </td>
                </tr>
            </table>
        </div>
    </li>
    <br>
    <li>TUJUAN JABATAN
        <small class="mini">
            Merupakan kalimat singkat yang menjelaskan tujuan diciptakannya jabatan tersebut di suatu
            organisasi, menggambarkan hasil akhir yang hendak dicapai, cara mencapainya, bagaimana fungsi
            jabatan dilaksanakan, apa saja yang dipengaruhi oleh jabatan, dan untuk apa fungsi tersebut
            dijalankan.
        </small>
        <div style="font-weight: normal; text-align: justify; margin-left:3px;">
            <?= nl2br($data->fungsi_utama) ?>
        </div>
    </li>
    <br>
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
                    @foreach ($data->aktivitas as $x => $v)
                        
                            <tr>
                                <td style="text-align: center"> {{ $x + 1 }}</td>
                                <td style="text-align: justify">{{ $v['aktivitas'] }}</td>
                                <td style="text-align: justify">{{ $v['output'] }}</td>
                            </tr>
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </li>
    <br />
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
                    @foreach ($data['aktivitas_generik'] as $x => $v)
                            <tr>
                                <td style="text-align: center"> {{ $x + 1 }}</td>
                                <td style="text-align: justify">{{ $v['aktivitas'] }}</td>
                                <td style="text-align: justify">{{ $v['output'] }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </li>
    <br />
    <li>Dimensi Jabatan
        <small class="mini">
            Memuat semua data relevan yang dapat diukur dan digunakan untuk menggambarkan cakupan
            atau besarnya tanggung jawab yang dipegang termasuk ringkasan data kuantitatif dan
            kualitatif yang etrkait dengan besarnya tugas ini.
        </small>

        5.a. Dimensi Finansial
        <div style="font-weight: normal;">
            <table>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{-- {{ $data['anggaran'] == 'Investasi' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Anggaran Investasi</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{-- {{ $data['anggaran'] == 'Operasional' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Anggaran Operasional</td>
                </tr>
            </table>
            <b>Accountability</b>
            <table>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == null ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Non Quantifiable</td>
                    <td></td>
                    <td>
                        < 650 Juta</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == '650 juta < n ≤ 6.5 milyar' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Very Small</td>
                    <td></td>
                    <td>650 Juta - 6,5 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == '6.5 milyar < n ≤ 65 milyar' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Small</td>
                    <td></td>
                    <td>6,5 Milyar - 65 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == '65 milyar < n ≤ 650 milyar' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Medium</td>
                    <td></td>
                    <td>65 Milyar - 650 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == '650 Milyar - 6,5 Trilyun' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Large</td>
                    <td></td>
                    <td>650 Milyar - 6,5 Trilyun</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ $data['kewenangan_pengadaan'] == '6,5 Trilyun - 65 Trilyun' ? 'V' : '' }}
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
                        {{-- {{ $data['nature_impact'] == 'Prime' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Prime</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{-- {{ $data['nature_impact'] == 'Share' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Share</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{-- {{ $data['nature_impact'] == 'Contributory' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Contributory</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{-- {{ $data['nature_impact'] == 'Remote' ? 'V' : '' }} --}}
                    </td>
                    <td></td>
                    <td>Remote</td>
                </tr>
            </table>
        </div>
        <br>
        5.b. Dimensi Non-keuangan
        <div style="font-weight: normal;">
            a. Jumlah staff yang dikelola di sub bidangnya sesuai FTK
            <table style="width: 100%; margin-left: 20px;">
                <tr>
                    <td style="width: 20%;">Jumlah Bawahan Langsung</td>
                    <td>:</td>
                    <td>
                        {{ $data['jabatan']->bawahan_langsung ?? '0' }}
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>:</td>
                    <td>
                        {{ $data['jabatan']->total_bawahan ?? '0' }}
                    </td>
                </tr>
            </table>
            b. Proses bisnis yang dikelola di sub bidangnya

        </div>
    </li>
    <br />

    <li>HUBUNGAN KERJA
        <small class="mini">
            Menggambarkan hubungan kedinasan antara pemegang jabatan dengan jabatan lain dalam
            perusahaan maupun di perusahaan lain, yang disertai dengan deskripsi tujuan dari hubungan
            kerja tersebut.
        </small>
        <div style="font-weight: normal">
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">

                    <table class="table " id="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;width:5%; ">No</th>
                                <th style="text-align: center;width:30%; ">Komunikasi Internal</th>
                                <th style="text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['komunikasi_internal'] as $x => $v)
                                    <tr>
                                        <td style="text-align: center"> {{ $no++ }}</td>
                                        <td style="text-align: center;">{{ $v['subjek'] }}</td>
                                        <td style="text-align: justify;">{{ $v['tujuan'] }}</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <table class="table " id="table">
                        <thead>
                            <tr>
                                <th style="text-align: center; width:5%;">No</th>
                                <th style="text-align: center;width:30%; ">Komunikasi Eksternal</th>
                                <th style="text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach ($data['komunikasi_external'] as $x => $v)
                                    <tr>
                                        <td style="text-align: center"> {{ $no++ }}</td>
                                        <td style="text-align: center;">{{ $v['subjek'] }}</td>
                                        <td style="text-align: justify;">{{ $v['tujuan'] }}</td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </li>
    <br />
    <li>MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA
        <small class="mini">
            Merupakan uraian atas hal-hal yang menjadi permasalahan bagi pemangku jabatan sebagai akibat dari
            adanya kesulitan dalam pencapaian tujuan atau target yang ditetapkan.
        </small>
        <div style="font-weight: normal">
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:5%;">No</th>
                            <th style=" text-align: center">MASALAH, KOMPLEKSITAS KERJA DAN TANTANGAN UTAMA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['tantangan'] as $x => $v)
                            <tr>
                                <td style="text-align: center"> {{ $x + 1 }}</td>
                                @if ( isset($v['TANTANGAN']))
                                        <td style="text-align: center;">{{ $v['TANTANGAN'] }}</td>
                                        @else
                                        <td style="text-align: center;">{{ $v['definisi'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <br>
    <li>WEWENANG JABATAN
        <small class="mini">
            Menjelaskan sejauh mana peran jabatan ini dalam pengambilan keputusan dan dampak apa yang dapat
            ditimbulkan dari keputusan yang diambilnya.
        </small>
        <div style="font-weight: normal">
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:5%;">No</th>
                            <th style=" text-align: center">WEWENANG JABATAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['pengambilan_keputusan'] as $x => $v)
                            <tr>
                                <td style="text-align: center"> {{ $x + 1 }}</td>
                                @if ( isset($v['pengambilan_keputusan']))
                                <td style="text-align: center;">{{ $v['pengambilan_keputusan'] }}</td>
                                @else
                                <td style="text-align: center;">{{ $v['definisi'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    </br>
    <li>SPESIFIKASI JABATAN
        <small class="mini">
            Menguraikan dan menjelaskan pendidikan, pengetahuan pokok, keterampilan dan pengalaman minimal serta
            kompetensi yang diperlukan untuk mencapai tujuan jabatan, yang terdiri atas kualifikasi jabatan,
            kemampuan dan pengalaman, dan kompetensi.
        </small>
        <div style="font-weight: normal">
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:5%;">No</th>
                            <th style=" text-align: center">Pendidikan</th>
                            <th style=" text-align: center">Pengalaman</th>
                            <th style=" text-align: center">Bidang Studi</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($data['pendidikan'] as $i => $item)
                            @php
                                $bidangQuery = (new \App\Models\M_MAP_PENDIDIKAN())->getBidang($item->map_pendidikan_id);
                                $bidang = '';
                                if ($bidangQuery->count() == 1) {
                                    foreach ($bidangQuery as $b) {
                                        $bidang .= $b->bidang_studi;
                                    }
                                } elseif ($bidangQuery->count() > 1) {
                                    $bidang = '<ol>';
                                    foreach ($bidangQuery as $b) {
                                        $bidang .= "<li>$b->bidang_studi</li>";
                                    }
                                    $bidang .= '</ol>';
                                }
        
                                $pengalaman = $item->pengalaman == '' || $item->pengalaman == 'FG' || $item->pengalaman == 0 
                                    ? '<i>fresh graduate</i>'
                                    : "pengalaman minimal $item->pengalaman tahun";
        
                                $jobdesc = $item->jobdesc != '' ? $item->jobdesc : '';
                            @endphp
        
                            <tr>
                                <td style="text-align: center;">{{ $i + 1 }}</td>
                                <td style="text-align: center;">{{ $item->pendidikan }}</td>
                                <td class="tex-left">{!! $bidang !!}</td>
                                <td style="text-align: center;">{!! $pengalaman !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <b>Kemampuan dan Pengalaman</b>
            <ol type="a" style="padding-left: 0; margin-left: 2; list-style-position: inside;">
                <li> {{ $jobdesc ?? "" }} </li>
            </ol>
        </div>
        </div>
        </br>
    </li>
    
    <li>STRUKTUR ORGANISASI
        <small class="mini">
            Memberikan gambaran posisi jabatan tersebut di dalam organisasi, yang memperlihatkan posisi jabatan atasan
            langsung, bawahan langsung serta rekan kerja (peers).
        </small>
        @if (isset($data->struktur_organisasi))
        {!! $data->struktur_organisasi !!}
        <div style="height: 20%; margin-bottom:20px; display:block;"></div>
        @endif
    </li>
    <br>
    <li>KEBUTUHAN KOMPETENSI JABATAN (KKJ)
        <small class="mini">
            Memberikan informasi mengenai kebutuhan kemahiran/kompetensi yang diharapkan dalam suatu jabatan.
        </small>
        <div style="font-weight: normal">
            <b>>> Kompetensi Utama</b>
            <small class="mini">
                Kompetensi perilaku yang harus dimiliki oleh seluruh individu Pegawai dalam organisasi, pada semua
                fungsi dan Jenjang Jabatan.
            </small>
            <div class="form-group">
                <table class="table " id="table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:5%;">No</th>
                            <th style="text-align: center">Kode Kompetensi</th>
                            <th style="text-align: center">Kompetensi</th>
                            <th style="text-align: center">Penjelasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="form-group" style="font-weight: normal">
            <b>>> Kompetensi Peran</b>
            <small class="mini">
                Kompetensi perilaku yang dipersyaratkan agar individu Pegawai dapat berhasil dalam suatu posisi, peran,
                dan Jenjang Jabatan yang spesifik.
            </small>
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="text-align: center; width:5%;">No</th>
                        <th style="text-align: center">Kode Kompetensi</th>
                        <th style="text-align: center">Kompetensi</th>
                        <th style="text-align: center">Kategori</th>
                        <th style="text-align: center">Penjelasan</th>
                    </tr>
                </thead>
                <tbody>
                   
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
                        <th style="text-align: center; width:5%;">No</th>
                        <th style="text-align: center">Kode Kompetensi</th>
                        <th style="text-align: center">Kompetensi</th>
                        <th style="text-align: center">Kategori</th>
                        <th style="text-align: center">Penjelasan</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <br>
        <b>>> Kompetensi Teknis</b>
        <small class="mini">
            Kompetensi terkait dengan pengetahuan, keterampilan dan keahlian yang diperlukan sesuai dengan tugas pokok
            masing-masing individu Pegawai untuk menyelesaikan pekerjaan-pekerjaan secara teknis pada jabatannya.
        </small>
        <div class="form-group" style="font-weight: normal">
            <table class="table " id="table">
                <thead>
                    <tr>
                        <th style="text-align: center; width:5%;">No</th>
                        <th style="text-align: center">Kode Kompetensi</th>
                        <th style="text-align: center">Kompetensi</th>
                        <th style="text-align: center">Level</th>
                        <th style="text-align: center">Kategori</th>
                        <th style="text-align: center">Penjelasan</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <br>
    </li>
    <small style="font-weight: normal" class="mini">
        Keterangan :
        <br>
        - Kompetensi primer adalah Kompetensi yang wajib dimiliki oleh individu yang menduduki suatu Jabatan atau fungsi
        agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.
        <br>
        - Kompetensi sekunder adalah Kompetensi yang perlu dimiliki untuk mendukung individu yang menduduki suatu
        Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.
        <br>
        - Kompetensi core adalah Kompetensi teknis yang wajib dimiliki berdasarkan tugas pokok sesuai fungsi utama
        Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis
        <br>
        - Kompetensi enabler adalah Kompetensi teknis yang perlu dimiliki untuk mendukung tugas pokok sesuai fungsi
        utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis.
    </small>
</ol>
