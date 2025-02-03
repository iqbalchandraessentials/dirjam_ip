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
        .struktur-organisasi {
            page: struktur_organisasi;
            /* Gunakan halaman khusus STRUKTUR ORGANISASI */
            page-break-before: always;
            /* Paksa halaman baru sebelum STRUKTUR ORGANISASI */
            width: 100%;
            text-align: center;
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
            <span style="font-size: 18px; text-transform: capitalize;">TEMPLATE JABATAN <br />
                <span style="font-size: 16px">{{ $data['nama'] }}
                    <br />
                    <br />
        </th>
        <td style="width:110px">Tanggal</td>
        <td style="width:140px">{{ isset($data['created_at']) ? date_format($data['created_at'], 'd-m-Y') : '-' }}</td>
    </tr>
    <tr>
        <td>No Record</td>
        <td>{{ '-' }}</td>
    </tr>
    <tr>
        <td>Revisi</td>
        <td>{{ '-' }}</td>
    </tr>
    <tr>
        <td>Status</td>
        <td>{{ 'SUDAH DI VALIDASI' }}</td>
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
                    <td>{{ $data['nama'] }}</td>
                </tr>
                <tr>
                    <td>Sebutan Jabatan</td>
                    <td>:</td>
                    <td>
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)
                            @foreach ($data['jabatans'] as $key)
                                - {{ $key['jabatan'] ?? 'Tidak ada jabatan' }} <br>
                            @endforeach
                        @else
                            <p>Tidak ada data jabatan.</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Jenis Jabatan</td>
                    <td>:</td>
                    <td>
                        {{ strtoupper($data['type']) }}
                    </td>
                </tr>
                <tr>
                    <td>Jenjang Jabatan</td>
                    <td>:</td>
                    <td>
                        {{ strtoupper($data['masterJabatan']['jenjangJabatan']['nama']) }}
                    </td>
                </tr>
                <tr>
                    <td>Kelompok Bisnis</td>
                    <td>:</td>
                    <td>
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)

                            @foreach ($data['jabatans'] as $key)
                                - {{ strtoupper($key['namaProfesi']['nama_profesi']) ?? 'Tidak ada nama_profesi' }}
                                <br>
                            @endforeach
                        @else
                            <p>Tidak ada data nama_profesi.</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Unit Kerja</td>
                    <td>:</td>
                    <td>
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)

                            @foreach ($data['jabatans'] as $key)
                                - {{ strtoupper($key->description) ?? 'Tidak ada Unit Kerja' }} <br>
                            @endforeach
                        @else
                            <p>Tidak ada data Unit Kerja.</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Jabatan Atasan Langsung</td>
                    <td>:</td>
                    <td>
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)
                            @foreach ($data['jabatans'] as $key)
                                - {{ $key->atasan_langsung ?? 'Tidak ada atasan_langsung' }} <br>
                            @endforeach
                        @else
                            <p>Tidak ada data atasan_langsung.</p>
                        @endif
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
            {{ nl2br($data['fungsi_utama']) }}
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
                    @foreach ($data['tugasPokoUtamaGenerik'] as $x => $v)
                        @if (isset($v['jenis']) == 'utama')
                            <tr>
                                <td>{{ $x + 1 }}</td>
                                <td style="text-align: justify">{{ $v['aktivitas'] }}</td>
                                <td style="text-align: justify">{{ $v['output'] }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ $x + 1 }}</td>
                                <td style="text-align: justify">{{ $v['aktivitas'] }}</td>
                                <td style="text-align: justify"></td>
                            </tr>
                        @endif
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
                    @foreach ($data['tugas_pokok_generik'] as $x => $v)
                        @if ($v['jenis'] == 'generik')
                            <tr>
                                <td style="text-align: center"> {{ $x + 1 }}</td>
                                <td>{{ $v['aktivitas'] }}</td>
                                <td>{{ $v['output'] }}</td>
                            </tr>
                        @endif
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
                        {{ isset($data['anggaran']) && $data['anggaran'] == 'Investasi' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Anggaran Investasi</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['anggaran']) && $data['anggaran'] == 'Operasional' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Anggaran Operasional</td>
                </tr>
            </table>
            <b>Accountability</b>
            <table>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == null ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Non Quantifiable</td>
                    <td></td>
                    <td>
                        < 650 Juta</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == 'Very Small' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Very Small</td>
                    <td></td>
                    <td>650 Juta - 6,5 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == 'Small' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Small</td>
                    <td></td>
                    <td>6,5 Milyar - 65 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == 'Medium' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Medium</td>
                    <td></td>
                    <td>65 Milyar - 650 Milyar</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == 'Large' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Large</td>
                    <td></td>
                    <td>650 Milyar - 6,5 Trilyun</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['accountability']) && $data['accountability'] == 'Very Large' ? 'V' : '' }}
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
                        {{ isset($data['nature_impact']) && $data['nature_impact'] == 'Prime' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Prime</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['nature_impact']) && $data['nature_impact'] == 'Share' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Share</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['nature_impact']) && $data['nature_impact'] == 'Contributory' ? 'V' : '' }}
                    </td>
                    <td></td>
                    <td>Contributory</td>
                </tr>
                <tr>
                    <td style="width: 20px; text-align: center; border: 1px solid #000;">
                        {{ isset($data['nature_impact']) && $data['nature_impact'] == 'Remote' ? 'V' : '' }}
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
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)

                            @foreach ($data['jabatans'] as $key)
                                - {{ $key->bawahan_langsung ?? '0' }} <br>
                            @endforeach
                        @else
                            <p>0</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>:</td>
                    <td>
                        @if (isset($data['jabatans']) && count($data['jabatans']) > 0)

                            @foreach ($data['jabatans'] as $key)
                                - {{ $key->total_bawahan ?? '0' }} <br>
                            @endforeach
                        @else
                            <p>0</p>
                        @endif
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
                                <th style=" text-align: center;width:30%; ">Komunikasi Internal</th>
                                <th style=" text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($data['hubunganKerja'] as $x => $v)
                                @if ($v['jenis'] == 'internal' || $v['lingkup_flag'] == 'internal')
                                    <tr>
                                        <td>{{ $no++ }}
                                        </td>
                                        <td style="text-align: justify">
                                            {{ isset($v['subjek']) ? $v['subjek'] : $v['komunikasi'] }}</td>
                                        <td style="text-align: justify">{{ $v['tujuan'] }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td>1</td>
                                    <td colspan="2" style="text-align: center">Tidak ada data</td>
                                </tr>
                            @endforelse
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
                                <th style=" text-align: center;width:30%; ">Komunikasi Eksternal</th>
                                <th style=" text-align: center">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($data['hubunganKerja'] as $x => $v)
                                @if ($v['jenis'] == 'eksternal' || $v['lingkup_flag'] == 'external')
                                    <tr>
                                        <td>{{ $no++ }}
                                        </td>
                                        <td style="text-align: justify">
                                            {{ isset($v['subjek']) ? $v['subjek'] : $v['komunikasi'] }}</td>
                                        <td style="text-align: justify">{{ $v['tujuan'] }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td>1</td>
                                    <td colspan="2" style="text-align: center">Tidak ada data</td>
                                </tr>
                            @endforelse
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
                        @foreach ($data['masalah_kompleksitas_kerja'] as $x => $v)
                            <tr>
                                <td> {{ $x + 1 }}</td>
                                <td style="text-align: center">
                                    {{ isset($v['tantangan']) ? $v['tantangan'] : $v['definisi'] }}</td>
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
                        @foreach ($data['wewenang_jabatan'] as $x => $v)
                            <tr>
                                <td>{{ $x + 1 }}</td>
                                <td style="text-align: center">
                                    {{ isset($v['pengambilan_keputusan']) ? $v['pengambilan_keputusan'] : $v['definisi'] }}
                                </td>
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
                            <th style=" text-align: center">Bidang Studi</th>
                            <th style=" text-align: center">Pengalaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['spesifikasiPendidikan'] as $i => $item)
                            @php
                                $bidangQuery = (new \App\Models\M_MAP_PENDIDIKAN())->getBidang(
                                    $item->map_pendidikan_id,
                                );
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

                                $pengalaman =
                                    $item->pengalaman == '' || $item->pengalaman == 'FG' || $item->pengalaman == 0
                                        ? '<i>fresh graduate</i>'
                                        : "pengalaman minimal $item->pengalaman tahun";

                                $jobdesc = $item->jobdesc != '' ? $item->jobdesc : '';
                            @endphp

                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-center">{{ $item->pendidikan }}</td>
                                <td class="tex-left">
                                    @if (isset($item->bidang_studi))
                                        {{ $item->bidang_studi }}
                                    @else
                                        {!! $bidang !!}
                                    @endif
                                </td>
                                <td class="text-center">{!! $pengalaman !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <b>Kemampuan dan Pengalaman</b>
            <ol type="a" style="padding-left: 0; margin-left: 2; list-style-position: inside;">
                @if ($jobdesc)
                    <li> {{ $jobdesc ?? '' }} </li>
                @endif
                @foreach ($data['kemampuan_dan_pengalaman'] as $v)
                    <li>{{ $v->definisi }}</li>
                @endforeach
            </ol>
        </div>
        </div>
        </br>
    </li>
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
                        @php $no = 1; @endphp
                        @forelse ($data['keterampilan_non_teknis'] as $x => $v)
                            @if ($v['kategori'] == 'UTAMA')
                                <tr style="text-align: center" class="text-center">
                                    <td> {{ $no++ }}</td>
                                    <td>{{ $v['kode'] }}</td>
                                    <td style="text-align: justify">{{ $v['detail']['nama'] ?? '' }}</td>
                                    <td style="text-align: justify">{{ $v['detail']['definisi'] ?? '' }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td>1</td>
                                <td colspan="3" style="text-align: center">Tidak ada data</td>
                            </tr>
                        @endforelse
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
                    @php $no = 1; @endphp
                    @forelse ($data['keterampilan_non_teknis'] as $x => $v)
                        @if ($v['kategori'] == 'PERAN')
                            <tr style="text-align: center" class="text-center">
                                <td> {{ $no++ }}</td>
                                <td>{{ $v['kode'] }}</td>
                                <td style="text-align: justify">{{ $v['detail']['nama'] }}</td>
                                <td>{{ strtoupper($v['jenis']) }}</td>
                                <td style="text-align: justify">{{ $v['detail']['definisi'] }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>1</td>
                            <td colspan="4" style="text-align: center">Tidak ada data</td>
                        </tr>
                    @endforelse
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
                    @php $no = 1; @endphp
                    @forelse ($data['keterampilan_non_teknis'] as $x => $v)
                        @if ($v['kategori'] == 'FUNGSI')
                            <tr>
                                <td style="text-align: center;"> {{ $no++ }}</td>
                                <td style="text-align: center;">{{ $v['kode'] }}</td>
                                <td style="text-align: justify;">{{ $v['detail']['nama'] ?? '' }}</td>
                                <td style="text-align: center; text-transform: uppercase;">{{ $v['jenis'] ?? '' }}
                                </td>
                                <td style="text-align: justify">{{ $v['detail']['definisi'] ?? '' }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>1</td>
                            <td colspan="4" style="text-align: center">Tidak ada data</td>
                        </tr>
                    @endforelse
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
                    @php $no = 1; @endphp
                    @forelse ($data['keterampilan_teknis'] as $x => $v)
                        @if (isset($v['master']['nama']))
                            <tr style="text-align: center">
                                <td> {{ $no++ }}</td>
                                <td>{{ $v['kode'] }}</td>
                                <td style="text-align: justify">{{ $v['master']['nama'] }}</td>
                                <td>{{ $v['level'] }}</td>
                                <td>{{ $v['kategori'] }}</td>
                                <td style="text-align: justify">
                                    {{ $v->detailMasterKompetensiTeknis->perilaku ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>1</td>
                            <td colspan="5" style="text-align: center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <br>
        <small style="font-weight: normal" class="mini">
            Keterangan :
            <br>
            - Kompetensi primer adalah Kompetensi yang wajib dimiliki oleh individu yang menduduki suatu Jabatan atau
            fungsi
            agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang spesifik.
            <br>
            - Kompetensi sekunder adalah Kompetensi yang perlu dimiliki untuk mendukung individu yang menduduki suatu
            Jabatan atau fungsi agar individu dapat berhasil pada suatu posisi, fungsi, atau Jenjang Jabatan yang
            spesifik.
            <br>
            - Kompetensi core adalah Kompetensi teknis yang wajib dimiliki berdasarkan tugas pokok sesuai fungsi utama
            Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis
            <br>
            - Kompetensi enabler adalah Kompetensi teknis yang perlu dimiliki untuk mendukung tugas pokok sesuai fungsi
            utama Jabatan agar individu dapat berhasil pada suatu posisi dalam fungsi bisnis.
        </small>
        <br>
</ol>
