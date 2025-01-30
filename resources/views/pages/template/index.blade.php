@extends('master')

@section('title', 'Template Jabatan | Direktori Jabatan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">List Template Jabatan </h4>
                        </div>
                    </div>
                </div>

                <div class="box-body">
                    @if (session('success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                <li>Import data gagal !!</li>
                                @foreach ($errors->all() as $error)
                                    <li> error: {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div style="margin-bottom: 15px">
                        <form action="{{ route('import.templateJabatan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                        <label for="file">Upload Excel File:</label>
                        <input type="file" name="file" id="file" required>
                        <button type="submit" class="btn border-t-orange-400 btn-sm">Import</button>
                    </form>
                </div>


                    <div class="table-responsive">
                        <div class="container mt-4">
                            <h3>Data Template Jabatan</h3>
                        
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-left">No.</th>
                                        <th class="text-center">Master Jabatan</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Jenjang</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
     $(document).ready(function () {
    let table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('template_jabatan.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'master_jabatan', name: 'master_jabatan' },
            { data: 'unit_kd', name: 'unit_kd' },
            { data: 'jen', name: 'jen' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        createdRow: function (row, data) {
            $(row).attr('data-href', "{{ url('template_jabatan') }}/" + data.master_jabatan);
            $(row).css('cursor', 'pointer');
        }
    });

    $('#datatable tbody').on('click', 'tr', function () {
        let url = $(this).data('href');
        if (url) {
            window.location.href = url;
        }
    });
});


    </script>
@endsection