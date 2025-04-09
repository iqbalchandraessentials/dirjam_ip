 <!-- Modal -->
 <div class="modal fade" id="modalKompetensi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Form Kompetensi Teknis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formKompetensi" method="POST">
                @csrf
                <input type="hidden" id="kompetensi_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Master</label>
                        <input type="text" class="form-control" id="kode_master" name="kode_master" value="{{ $data['kode'] }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="">Pilih Level</option>
                            @for ($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Perilaku</label>
                        <textarea class="form-control" id="perilaku" name="perilaku" rows="4" required></textarea>
                    </div>
                    <input type="hidden" id="kode_master_level" name="kode_master_level">
                    <input type="hidden" id="created_by" name="created_by" value="{{ Session::get('user')['nama'] ?? 'SYSTEM' }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--  --}}