@extends('master')

@section('title', 'Daftar Pengajuan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="list-tab" data-toggle="tab" href="#list"
                               role="tab" aria-controls="list" aria-selected="true">List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fungsi-utama-tab" data-toggle="tab" href="#fungsi-utama"
                               role="tab" aria-controls="fungsi-utama" aria-selected="false">Fungsi Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tanggung-jawab-tab" data-toggle="tab" href="#tanggung-jawab"
                               role="tab" aria-controls="tanggung-jawab" aria-selected="false">Tanggung Jawab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kewenangan-tab" data-toggle="tab" href="#kewenangan"
                               role="tab" aria-controls="kewenangan" aria-selected="false">Kewenangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="persyaratan-kompetensi-tab" data-toggle="tab" href="#persyaratan-kompetensi"
                               role="tab" aria-controls="persyaratan-kompetensi" aria-selected="false">Persyaratan Kompetensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hubungan-kerja-tab" data-toggle="tab" href="#hubungan-kerja"
                               role="tab" aria-controls="hubungan-kerja" aria-selected="false">Hubungan Kerja</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="rekomendasi-tab" data-toggle="tab" href="#rekomendasi"
                               role="tab" aria-controls="rekomendasi" aria-selected="false">Rekomendasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pengambilan-keputusan-tab" data-toggle="tab" href="#pengambilan-keputusan"
                               role="tab" aria-controls="pengambilan-keputusan" aria-selected="false">Pengambilan Keputusan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profesi-tab" data-toggle="tab" href="#profesi"
                               role="tab" aria-controls="profesi" aria-selected="false">Profesi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tantangan-tab" data-toggle="tab" href="#tantangan"
                               role="tab" aria-controls="tantangan" aria-selected="false">Tantangan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary"
                               role="tab" aria-controls="summary" aria-selected="false">Summary</a>
                        </li>
                    </ul>
                
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
                                <div class="col">
                                    <div class="box-header">
                                        <div class="row">
                                            <div class="col-6 text-left">
                                                <h4 class="box-title">List Job Description</h4>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                            <div class="form-group d-flex align-items-center">
                                                                <label for="jenjang" class="mr-3 mb-0">Unit:</label>
                                                            <select class="form-control select2" style="width: 100%;">
                                                                <option selected disabled>All</option>
                                                                <option>Office Equipment</option>
                                                                <option>Stationery</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group d-flex align-items-center">
                                                            <label for="jenjang" class="mr-3 mb-0">Jenjang:</label>
                                                            <input type="text" class="form-control" id="jenjang" name="jenjang" placeholder="Jenjang jabatan">
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="btn btn-primary"><i class="ti-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped dataTables">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center text-nowrap">Template</th>
                                                            <th class="text-left">Jenjang</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Unit</th>
                                                            <th class="text-center">Opsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                        
                        <div class="tab-pane fade" id="fungsi-utama" role="tabpanel" aria-labelledby="fungsi-utama-tab">
                            <div class="row g-0">
                                <h1>Fungsi Utama</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="tanggung-jawab" role="tabpanel" aria-labelledby="tanggung-jawab-tab">
                            <div class="row g-0">
                                <h1>Tanggung Jawab</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="kewenangan" role="tabpanel" aria-labelledby="kewenangan-tab">
                            <div class="row g-0">
                                <h1>Kewenangan</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="persyaratan-kompetensi" role="tabpanel" aria-labelledby="persyaratan-kompetensi-tab">
                            <div class="row g-0">
                                <h1>Persyaratan Kompetensi</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="hubungan-kerja" role="tabpanel" aria-labelledby="hubungan-kerja-tab">
                            <div class="row g-0">
                                <h1>Hubungan Kerja</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="rekomendasi" role="tabpanel" aria-labelledby="rekomendasi-tab">
                            <div class="row g-0">
                                <h1>Rekomendasi</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="pengambilan-keputusan" role="tabpanel" aria-labelledby="pengambilan-keputusan-tab">
                            <div class="row g-0">
                                <h1>Pengambilan Keputusan</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="profesi" role="tabpanel" aria-labelledby="profesi-tab">
                            <div class="row g-0">
                                <h1>Profesi</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="tantangan" role="tabpanel" aria-labelledby="tantangan-tab">
                            <div class="row g-0">
                                <h1>Tantangan</h1>
                            </div>
                        </div>
                
                        <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                            <div class="row g-0">
                                <h1>Summary</h1>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>
        </div>

    @endsection
