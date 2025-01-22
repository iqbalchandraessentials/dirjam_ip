  <!-- Modal Create/Update -->
  <div class="modal fade" id="modalForm" tabindex="-1" role="dialog"
  aria-labelledby="modalFormLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="" method="POST" id="formSave">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalFormLabel">Tambah/Edit Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id" id="dataId">
                  <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" name="nama" id="nama"
                          required>
                  </div>
                  <div class="form-group">
                      <label for="pengalaman">Pengalaman</label>
                      <input type="text" class="form-control" name="pengalaman" id="pengalaman"
                          required>
                  </div>
                  <div class="form-group">
                      <label for="jenjang_jabatan">Jenjang Jabatan</label>
                      <input type="text" class="form-control" name="jenjang_jabatan"
                          id="jenjang_jabatan" required>
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


<!-- Modal Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog"
  aria-labelledby="modalDeleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form action="{{ route('master.pendidikan.delete') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modalDeleteLabel">Konfirmasi Hapus</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Apakah Anda yakin ingin menghapus data <strong id="deleteNama"></strong>?
                  </p>
                  <input type="hidden" name="id" id="deleteId">
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