<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA PETUGAS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formData" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="name" class="control-label">NIP <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nip_petugas" name="nip_petugas">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip_petugas"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Nama Petugas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_petugas" name="nama_petugas">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_petugas"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Alamat Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email_petugas" name="email_petugas">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email_petugas"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="telp_petugas" name="telp_petugas" pattern="[0-9]{9,14}">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-telp_petugas"></div>
                </div>
                <div class="form-group">
                        <label for="name" class="control-label">OPD <span class="text-danger">*</span></label><br>
                        <select class="form-control" name="id_opd" id="id_opd" required>     
                            @foreach($opds as $opd)
                            <option selected="selected"  value="{{$opd->id}}">{{$opd->nama_opd}}</option>
                            @endforeach
                            <option selected="selected"  value="">--Pilih Asal OPD--</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_barang"></div>
                    </div>
                <div class="form-group">
                    <label for="name" class="control-label">Kata Sandi Petugas <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="kata_sandi_petugas" name="kata_sandi_petugas" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kata_sandi_petugas"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Foto Petugas <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="foto_petugas" name="foto_petugas" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_petugas"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Level <span class="text-danger">*</span></label>
                    <select class="form-control" id="level" name="level">
                        <option value="">--Pilih Level Petugas--</option>
                        <option value="admin">Admin</option>
                        <option value="satgas">Satgas</option>
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-level"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary-petugas" id="store">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
//button create post event
$('body').on('click', '#btn-create-post', function () {
    //open modal
    $('#modal-create').modal('show');
});
//action create post
$('#store').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    var data = new
    FormData(document.getElementById("formData"));
    data.append("nip_petugas", $('#nip_petugas').val());
    data.append("nama_petugas", $('#nama_petugas').val());
    data.append("email_petugas",$('#email_petugas').val());
    data.append("telp_petugas",$('#telp_petugas').val());
    data.append("id_opd", $('#id_opd').val());
    data.append("kata_sandi_petugas", $('#kata_sandi_petugas').val());
    data.append('foto_petugas', $('input[id="foto_petugas"]')[0].files[0]);
    data.append("level",$('#level').val());
    //ajax
    $.ajax({
        url: '{{ url('api/petugasa') }}',
        type: "POST",
        data: data,
        cache: false,
        dataType: 'json',
        processData: false,
        contentType: false,
        timeout: 0,
        mimeType: "multipart/form-data",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        
        success:function(response){
            //show success message
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

            // Ensure the page reloads when the timer expires
            setTimeout(function() {
                location.reload();
            }, 3000);

            /*//data post
            let petugas = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.nip_petugas}</td>
                    <td>${response.data.nama_petugas}</td>
                    <td>${response.data.email_petugas}</td>
                    <td>${response.data.telp_petugas}</td>
                    <td>${response.data.id_opd}</td>
                    
                    <td><img src="{{ url('storage/petugas')}}${"/"+response.data.foto_petugas}" width="30" height="30"></td>
                    <td>${response.data.level}</td>
                    <td class="text-left">
                        <a href="javascript:void(0)"id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm" style="padding: 6px;">
                            <img alt="icon" src="assets/media/icons/edit.png" style="width: 16px; height: 16px;">
                        </a>
                        <a href="javascript:void(0)"id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm" style="padding: 6px;">
                            <img alt="icon" src="assets/media/icons/delete.png" style="width: 16px; height: 16px;">
                        </a>
                    </td>
                </tr>
            `;
            //append to table
            $('#table-petugasa').prepend(petugas);
            //clear form
            $('#nip_petugas').val('');
            $('#nama_petugas').val('');
            $('#email_petugas').val('');
            $('#telp_petugas').val('');
            $('#id_opd').val('');
            
            $('#foto_petugas').val('');
            $('#level').val('');*/

            //close modal
            $('#modal-create').modal('hide');
        },
        
        error:function(error){
            for (const value of data.values()) {
                    console.log(value);
                }
                if(error.responseJSON.nip_petugas[0]) {
                    $('#alert-nip_petugas').removeClass('d-none');
                    $('#alert-nip_petugas').addClass('d-block');
                    $('#alert-nip_petugas').html(error.responseJSON.nip_petugas[0]);

                }
                if(error.responseJSON.nama_petugas[0]) {
                    $('#alert-nama_petugas').removeClass('d-none');
                    $('#alert-nama_petugas').addClass('d-block');
                    $('#alert-nama_petugas').html(error.responseJSON.nama_petugas[0]);

                }
                if(error.responseJSON.email_petugas[0]) {
                    $('#alert-email_petugas').removeClass('d-none');
                    $('#alert-email_petugas').addClass('d-block');
                    $('#alert-email_petugas').html(error.responseJSON.email_petugas[0]);

                }
                
                if(error.responseJSON.telp_petugas[0]) {
                    $('#alert-telp_petugas').removeClass('d-none');
                    $('#alert-telp_petugas').addClass('d-block');
                    $('#alert-telp_petugas').html(error.responseJSON.telp_petugas[0]);

                }
                if(error.responseJSON.id_opd[0]) {
                    $('#alert-id_opd').removeClass('d-none');
                    $('#alert-id_opd').addClass('d-block');
                    $('#alert-id_opd').html(error.responseJSON.id_opd[0]);

                }
                if(error.responseJSON.kata_sandi_petugas[0]) {
                    $('#alert-kata_sandi_petugas').removeClass('d-none');
                    $('#alert-kata_sandi_petugas').addClass('d-block');
                    $('#alert-kata_sandi_petugas').html(error.responseJSON.kata_sandi_petugas[0]);

                }
                if(error.responseJSON.foto_petugas[0]) {
                    $('#alert-foto_petugas').removeClass('d-none');
                    $('#alert-foto_petugas').addClass('d-block');
                    $('#alert-foto_petugas').html(error.responseJSON.foto_petugas[0]);

                }
                if(error.responseJSON.level[0]) {
                    $('#alert-level').removeClass('d-none');
                    $('#alert-level').addClass('d-block');
                    $('#alert-level').html(error.responseJSON.level[0]);

                }
        }
    });
});
</script>