<div class="modal fade" id="editProfilModal" tabindex="-1" role="dialog" aria-labelledby="editProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfilModalLabel">Edit Data Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfilForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_petugas" class="control-label">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama_petugas" name="nama_petugas" value="{{ $petugasa->nama_petugas }}">
                    </div>
                    <div class="form-group">
                        <label for="nip_petugas" class="control-label">Nomor Induk Pegawai</label>
                        <input type="text" class="form-control" id="nip_petugas" name="nip_petugas" value="{{ $petugasa->nip_petugas }}">
                    </div>
                    <div class="form-group">
                        <label for="email_petugas" class="control-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email_petugas" name="email_petugas" value="{{ $petugasa->email }}">
                    </div>
                    <div class="form-group">
                        <label for="telp_petugas" class="control-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="telp_petugas" name="telp_petugas" value="{{ $petugasa->telp_petugas }}">
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Foto Petugas</label>
                        <input type="file" class="form-control" id="foto_petugas" name="foto_petugas">
                        <img src="{{url('storage/petugas/'.$petugasa->foto_petugas)}}" id="foto_petugas-edit-preview" width="50" height="50">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="id_opd-edit" class="control-label">OPD</label>
                        <select class="form-control" id="id_opd-edit" name="id_opd" required>
                            @foreach($opds as $opd)
                                <option value="{{ $opd->id }}" {{ $petugasa->id_opd == $opd->id ? 'selected' : '' }}>
                                    {{ $opd->nama_opd }}
                                </option>
                            @endforeach
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-barang-edit"></div>
                    </div><br><br>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button class="btn btn-primary-profile" id="storeProfile">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#btn-edit-profil').on('click', function() {
            $('#editProfilModal').modal('show');
        });

        $('#editProfilForm').unbind('submit').bind('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('_method', 'PUT');

            $.ajax({
                url: '{{ route("petugas.profile.update", $petugasa->id) }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editProfilModal').modal('hide');
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    }).then((result) => {
                            // Reload the page after the alert closes
                            location.reload();
                    });

                    // Also ensure the page reloads when the timer expires
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
