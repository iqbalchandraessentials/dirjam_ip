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
                      <label for="nama">Pendidikan</label>
                      <select class="form-control" style="width: 100%;" name="nama" id="nama" required>
                        <option selected disabled>Pilih</option>
                        <option value="SMK/STM">SMK/STM</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="jenjang_jabatan">Jenjang Jabatan</label>
                    <select class="form-control" style="width: 100%;"  name="jenjang_jabatan" id="jenjang_jabatan" required>
                        <option selected disabled>Pilih</option>
                        @foreach ($jenjang as $v)
                        <option value="{{$v->jenjang_kd}}">( {{$v->jenjang_kd}} ) {{$v->jenjang_nama}}</option>
                        @endforeach
                    </select>
                </div> 
                  <div class="form-group">
                      <label for="pengalaman">Pengalaman</label>
                      <input type="text" class="form-control" name="pengalaman" id="pengalaman"
                          required>
                  </div>
                  <small>*) 0 untuk <i>fresh graduate</i></small>
              

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