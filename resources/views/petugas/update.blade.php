<!-- Modal -->

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT DATA PETUGAS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="post_id">
                    <div class="form-group">
                        <label for="name" class="control-label">NIP <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="nip_petugas-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nip_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Petugas <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="nama_petugas-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Email Petugas <span class="text-danger">*</span> </label>
                        <input type="email" class="form-control" id="email_petugas-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nomor Telepon <span class="text-danger">*</span> </label>
                        <input type="tel" class="form-control" id="telp_petugas-edit" pattern="[0-9]{9,14}">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-telp_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">OPD <span class="text-danger">*</span> </label>
                        <select class="form-control" id="id_opd-edit" required>
                            @foreach($opds as $opd)
                            <option selected="selected" value="{{$opd->id}}">{{$opd->nama_opd}}</option>
                            @endforeach
                            <option selected="selected" value=" ">--Pilih Asal OPD--</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-barang-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Kata Sandi Petugas <span class="text-danger">*</span> </label>
                        <input type="password" class="form-control" id="kata_sandi_petugas-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kata_sandi_petugas-edit"></div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Foto Petugas <span class="text-danger">*</span> </label>
                        <input type="file" class="form-control" id="foto_petugas-edit-input">
                        
                            <img id="foto_petugas-edit-preview" width="50" height="50">
                        
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_petugas-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Level <span class="text-danger">*</span></label>
                        <select class="form-control" id="level-edit" name="level-edit">
                            <option value="">--Pilih Level Petugas--</option>
                            <option value="admin">Admin</option>
                            <option value="satgas">Satgas</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-level-edit"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary-petugas" id="update">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    //button create post event
    $('body').on('click', '#btn-edit-post', function() {
        let post_id = $(this).data('id');
        //fetch detail post with ajax
        $.ajax({
            url: '{{url('api/petugasa')}}/' + post_id,
            type: "GET",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                //fill data to form
                $('#post_id').val(response.data.id);
                $('#nip_petugas-edit').val(response.data.nip_petugas);
                $('#nama_petugas-edit').val(response.data.nama_petugas);
                $('#email_petugas-edit').val(response.data.email);
                $('#telp_petugas-edit').val(response.data.telp_petugas);
                $('#id_opd-edit').val(response.data.id_opd);
                $('#kata_sandi_petugas-edit').val('');
                $('#foto_petugas-edit-preview').attr("src", "{{ url('storage/petugas')}}" + "/" + response.data.foto_petugas);
                //console.log(response.data.foto_petugas)
                $('#level-edit').val(response.data.level);
                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });
    //action update post
    $('#update').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        let post_id = $('#post_id').val()
        var form = new FormData();
        form.append("nip_petugas", $('#nip_petugas-edit').val());
        form.append("nama_petugas", $('#nama_petugas-edit').val());
        form.append("email_petugas", $('#email_petugas-edit').val());
        form.append("telp_petugas", $('#telp_petugas-edit').val());
        form.append("id_opd", $('#id_opd-edit').val());
        if ($('#kata_sandi_petugas-edit').val() !== '') {
            form.append("kata_sandi_petugas", $('#kata_sandi_petugas-edit').val());
        }
        
        if ($('#foto_petugas-edit-input')[0].files[0]) {
            form.append("foto_petugas", $('#foto_petugas-edit-input')[0].files[0]);
        }
        //form.append("foto_petugas", $('input[id="foto_petugas-edit"]')[0].files[0]);
        form.append("level", $('#level-edit').val());
        form.append("_method", "PUT");
        //ajax
        $.ajax({
            url: '{{url('api/petugasa')}}/' + post_id,
            type: "POST",
            data: form,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            timeout: 0,
            mimeType: "multipart/form-data",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
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
                
                //data post
                /*let post = `
        <tr id="index_${response.data.id}">
        <td>${response.data.nip_petugas}</td>
        <td>${response.data.nama_petugas}</td>
        <td>${response.data.email_petugas}</td>
        <td>${response.data.telp_petugas}</td>
        <td>${response.data.id_opd}</td>
        <td>
        <img src="{{ url('storage/petugas')}}${"/"+response.data.foto_petugas}" width=30 height=30>
        </td>
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
                //append to post data
                $(`#index_${response.data.id}`).replaceWith(post);*/
                
                //close modal
                $('#modal-edit').modal('hide');

            },
            error: function(error) {
                console.log(error)
                if (error.responseJSON.nip_petugas[0]) {
                    //show alert
                    $('#alert-nip_petugas-edit').removeClass('d-none');
                    $('#alert-nip_petugas-edit').addClass('d-block');
                    //add message to alert
                    $('#alert-nip_petugas-edit').html(error.responseJSON.nip_petugas[0]);

                }
                if (error.responseJSON.nama_petugas[0]) {
                    //show alert
                    $('#alert-nama_petugas-edit').removeClass('d-none');
                    $('#alert-nama_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-nama_petugas-edit').html(error.responseJSON.nama_petugas[0]);

                }
                if (error.responseJSON.email_petugas[0]) {
                    //show alert
                    $('#alert-email_petugas-edit').removeClass('d-none');
                    $('#alert-email_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-email_petugas-edit').html(error.responseJSON.email_petugas[0]);
                }

                if (error.responseJSON.telp_petugas[0]) {
                    //show alert
                    $('#alert-telp_petugas-edit').removeClass('d-none');
                    $('#alert-telp_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-telp_petugas-edit').html(error.responseJSON.telp_petugas[0]);

                }
                if (error.responseJSON.telp_petugas[0]) {
                    //show alert
                    $('#alert-telp_petugas-edit').removeClass('d-none');
                    $('#alert-telp_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-telp_petugas-edit').html(error.responseJSON.telp_petugas[0]);

                }
                if (error.responseJSON.id_opd[0]) {
                    //show alert
                    $('#alert-id_opd-edit').removeClass('d-none');
                    $('#alert-id_opd-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-id_opd-edit').html(error.responseJSON.id_opd[0]);

                }
                if (error.responseJSON.kata_sandi_petugas[0]) {
                    //show alert
                    $('#alert-kata_sandi_petugas-edit').removeClass('d-none');
                    $('#alert-kata_sandi_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-kata_sandi_petugas-edit').html(error.responseJSON.kata_sandi_petugas[0]);

                }
                if (error.responseJSON.foto_petugas[0]) {
                    //show alert
                    $('#alert-foto_petugas-edit').removeClass('d-none');
                    $('#alert-foto_petugas-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-foto_petugas-edit').html(error.responseJSON.foto_petugas[0]);

                }
                if (error.responseJSON.level[0]) {
                    //show alert
                    $('#alert-level-edit').removeClass('d-none');
                    $('#alert-level-edit').addClass('d-block');
                    //add message to alert

                    $('#alert-level-edit').html(error.responseJSON.level[0]);

                }
            }
        });
    });

    // Preview image on file selection
$('#foto_petugas-edit-input').change(function() {
    const [file] = this.files;
    if (file) {
        $('#foto_petugas-edit-preview').attr('src', URL.createObjectURL(file));
    }
});
</script>