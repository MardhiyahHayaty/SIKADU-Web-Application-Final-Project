<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"id="exampleModalLabel">Tambah Data Pemadaman Listrik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="name" class="control-label">Judul <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="judul_pemadaman" name="judul_pemadaman">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-judul_pemadaman"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Tanggal <span class="text-danger">*</span> </label>
                        <input type="date" class="form-control" id="tgl_mulai_pemadaman" name="tgl_mulai_pemadaman">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_mulai_pemadaman"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Jam Mulai <span class="text-danger">*</span> </label>
                        <input type="time" class="form-control" id="jam_mulai_pemadaman" name="jam_mulai_pemadaman">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jam_mulai_pemadaman"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Jam Selesai <span class="text-danger">*</span> </label>
                        <input type="time" class="form-control" id="jam_selesai_pemadaman" name="jam_selesai_pemadaman">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jam_selesai_pemadaman"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Lokasi <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="lokasi_pemadaman" name="lokasi_pemadaman">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-lokasi_pemadaman"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_petugas" name="id_petugas" value="{{ Auth::guard('admin')->user()->id }}">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_petugas"></div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-primary-pemadaman" id="store">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <script>
    $('body').on('click', '#btn-create-post', function () {
        $('#modal-create').modal('show');
    });
    $('#store').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var data = new
        FormData(document.getElementById("formData"));
        data.append("judul_pemadaman", $('#judul_pemadaman').val());
        data.append("tgl_mulai_pemadaman", $('#tgl_mulai_pemadaman').val());
        data.append("jam_mulai_pemadaman", $('#jam_mulai_pemadaman').val());
        data.append("jam_selesai_pemadaman", $('#jam_selesai_pemadaman').val());
        data.append("lokasi_pemadaman", $('#lokasi_pemadaman').val());
        //data.append("status_pemadaman", $('#status_pemadaman').val());
        data.append("id_petugas", $('#id_petugas').val());
        $.ajax({
            url: '{{url('api/pemadamans')}}',
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
                
                /*let pemadaman = `
                <tr id="index_${response.data.id}">
                <td>${response.data.judul_pemadaman}</td>
                <td>${response.data.tgl_mulai_pemadaman}</td>
                <td>${response.data.jam_mulai_pemadaman}</td>
                <td>${response.data.jam_selesai_pemadaman}</td>
                <td>${response.data.lokasi_pemadaman}</td>
                <td>${response.data.status_pemadaman}</td>
                <td>${response.data.id_petugas}</td>
                <td class="text-left">
                    <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                    
                </td>
                </tr>
                `;
                $('#table-pemadamans').prepend(pemadaman);
                $('#judul_pemadaman').val('');
                $('#tgl_mulai_pemadaman').val('');
                $('#jam_mulai_pemadaman').val('');
                $('#jam_selesai_pemadaman').val('');
                $('#lokasi_pemadaman').val('');
                $('#status_pemadaman').val('');
                $('#id_petugas').val('');*/
                $('#modal-create').modal('hide');
            },
            error:function(error){
                for (const value of data.values()) {
                    console.log(value);
                }
                if(error.responseJSON.judul_pemadaman[0]) {
                    $('#alert-judul_pemadaman').removeClass('d-none');
                    $('#alert-judul_pemadaman').addClass('d-block');
                    $('#alert-judul_pemadaman').html(error.responseJSON.judul_pemadaman[0]);

                }
                if(error.responseJSON.tgl_mulai_pemadaman[0]) {
                    $('#alert-tgl_mulai_pemadaman').removeClass('d-none');
                    $('#alert-tgl_mulai_pemadaman').addClass('d-block');
                    $('#alert-tgl_mulai_pemadaman').html(error.responseJSON.tgl_mulai_pemadaman[0]);

                }
                if(error.responseJSON.jam_mulai_pemadaman[0]) {
                    $('#alert-jam_mulai_pemadaman').removeClass('d-none');
                    $('#alert-jam_mulai_pemadaman').addClass('d-block');
                    $('#alert-jam_mulai_pemadaman').html(error.responseJSON.jam_mulai_pemadaman[0]);

                }
                if(error.responseJSON.jam_selesai_pemadaman[0]) {
                    $('#alert-jam_selesai_pemadaman').removeClass('d-none');
                    $('#alert-jam_selesai_pemadaman').addClass('d-block');
                    $('#alert-jam_selesai_pemadaman').html(error.responseJSON.jam_selesai_pemadaman[0]);

                }
                if(error.responseJSON.lokasi_pemadaman[0]) {
                    $('#alert-lokasi_pemadaman').removeClass('d-none');
                    $('#alert-lokasi_pemadaman').addClass('d-block');
                    $('#alert-lokasi_pemadaman').html(error.responseJSON.lokasi_pemadaman[0]);

                }
                
                if(error.responseJSON.id_petugas[0]) {
                    $('#alert-id_petugas').removeClass('d-none');
                    $('#alert-id_petugas').addClass('d-block');
                    $('#alert-id_petugas').html(error.responseJSON.id_petugas[0]);

                }
            }
        });
        });
</script>