 {{-- modal edit data --}}

 <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog"
 aria-labelledby="editUserModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <form id="editUserForm" method="POST" action="{{ route('users.update') }}">
             @csrf
             <div class="modal-body">
                 <input type="hidden" id="edit_user_id" name="id"> <!-- Ganti user_id menjadi id -->
         
                 <div class="form-group">
                     <label for="edit_name">Name</label>
                     <input type="text" class="form-control" id="edit_name" name="name" required>
                 </div>
                 <div class="form-group">
                     <label for="edit_userId">User ID</label> <!-- user_id digunakan untuk username -->
                     <input type="text" class="form-control" id="edit_userId" name="user_id" required>
                 </div>
         
                 <div class="form-group">
                     <label for="edit_email">Email</label>
                     <input type="email" class="form-control" id="edit_email" name="email" required>
                 </div>
         
                 <div class="form-group">
                     <label for="edit_password">New Password (optional)</label>
                     <input type="password" class="form-control" id="edit_password" name="password">
                 </div>
                 <div class="form-group">
                     <label for="edit_unit_kd">Unit</label>
                     <select style="width: 100%;" class="form-control select2" id="edit_unit_kd" name="unit_kd">
                         <option selected>--- Select Unit ---</option>
                         @foreach ($unit as $u)
                             <option value="{{ $u->unit_kd }}">{{ $u->unit_nama }}</option>
                         @endforeach
                     </select>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Save Changes</button>
             </div>
         </form>                            
     </div>
 </div>
</div>
{{--  --}}
<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal"
                 aria-label="Close"></button>
         </div>
         <div class="modal-body">
             <form action="{{ route('users.store') }}" method="POST">
                 @csrf
                 <div class="form-group">
                     <label for="user_id" class="form-label">User Id</label>
                     <input type="text" class="form-control" id="user_id" name="user_id"
                         required>
                 </div>
                 <div class="form-group">
                     <label for="name" class="form-label">Nama</label>
                     <input type="text" class="form-control" id="name" name="name"
                         required>
                 </div>
                 <div class="form-group">
                     <label for="email" class="form-label">Email</label>
                     <input type="email" class="form-control" id="email" name="email"
                         required>
                 </div>
                 <div class="form-group">
                     <label for="unit">Unit</label>
                     <select style="width: 100%;" class="form-control select2" name="unit_kd">
                         @foreach ($unit as $unit)
                             <option value="{{ $unit->unit_kd }}">
                                 {{ $unit->unit_nama }}
                             </option>
                         @endforeach
                     </select>
                 </div>
                 <div class="form-group">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" id="password" name="password"
                         required>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary"
                         data-dismiss="modal">Batal</button>
                     <button type="submit" class="btn btn-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
</div>