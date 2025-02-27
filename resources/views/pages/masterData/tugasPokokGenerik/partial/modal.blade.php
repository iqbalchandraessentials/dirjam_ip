<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog"
aria-labelledby="addModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <form action="{{ route('master.tugas_pokok_generik.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="generik" name="jenis">
                <div class="form-group">
                    <label for="jenis_jabatan">Jenis Jabatan</label>
                    <select class="form-control" style="width: 100%;" id="jenis_jabatan" name="jenis_jabatan" required>
                        <option selected disabled>Pilih</option>
                        <option value="struktural">Struktural</option>
                        <option value="fungsional">Fungsional</option>
                    </select>
                </div>                                                    
                <div class="form-group">
                    <label for="aktivitas">Aktivitas</label>
                    <textarea rows="6" class="form-control text-left" id="aktivitas" name="aktivitas" required></textarea>
                </div>
                <div class="form-group">
                    <label for="output">Output</label>
                    <textarea  class="form-control text-left" id="output" name="output" required rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog"
aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <form action="{{ route('master.tugas_pokok_generik.update') }}" method="POST">
        @csrf
        <input type="hidden" id="edit-id" name="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="generik" name="jenis">
                <div class="form-group">
                    <label for="jenis_jabatan">Jenis Jabatan</label>
                    <select class="form-control" style="width: 100%;" id="edit-jenis_jabatan" name="jenis_jabatan" required>
                        <option selected disabled>Pilih</option>
                        <option value="struktural">Struktural</option>
                        <option value="fungsional">Fungsional</option>
                    </select>
                </div>                                                    
                <div class="form-group">
                    <label for="edit-aktivitas">Aktivitas</label>
                        <textarea rows="6" class="form-control" id="edit-aktivitas" name="aktivitas" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-output">Output</label>
                    <textarea  class="form-control" id="edit-output" name="output" required rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
</div>
</div>

<!-- Modal Hapus Data -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
aria-labelledby="deleteModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <form action="{{ route('master.tugas_pokok_generik.delete') }}" method="POST">
        @csrf
        <input type="hidden" id="delete-id" name="id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </form>
</div>
</div>