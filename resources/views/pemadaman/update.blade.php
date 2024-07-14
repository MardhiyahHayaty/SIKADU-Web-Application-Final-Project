<!-- Modal -->

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT DATA PEMADAMAN LISTRIK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="post_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Judul <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="judul_pemadaman-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-judul_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Tanggal <span class="text-danger">*</span> </label>
                        <input type="date" class="form-control" id="tgl_mulai_pemadaman-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_mulai_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Jam Mulai <span class="text-danger">*</span> </label>
                        <input type="time" class="form-control" id="jam_mulai_pemadaman-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jam_mulai_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Jam Selesai <span class="text-danger">*</span> </label>
                        <input type="time" class="form-control" id="jam_selesai_pemadaman-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jam_selesai_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Lokasi <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="lokasi_pemadaman-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-lokasi_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Status <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="status_pemadaman-edit" style="background-color: #EFF2F5;" readonly>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status_pemadaman-edit"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_petugas-edit" name="id_petugas-edit" value="{{ Auth::guard('admin')->user()->id }}">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pemadaman-edit"></div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-primary-pemadaman" id="update">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
//button create post event
$('body').on('click', '#btn-edit-post', function () {
    let post_id = $(this).data('id');
    //fetch detail post with ajax
    $.ajax({
        url: '{{url('api/pemadamans')}}/'+post_id,
        type: "GET",
        cache: false,
        success:function(response){
            //fill data to form
            $('#post_id').val(response.data.id);
            $('#judul_pemadaman-edit').val(response.data.judul_pemadaman);
            $('#tgl_mulai_pemadaman-edit').val(response.data.tgl_mulai_pemadaman);
            $('#jam_mulai_pemadaman-edit').val(response.data.jam_mulai_pemadaman);
            $('#jam_selesai_pemadaman-edit').val(response.data.jam_selesai_pemadaman);
            $('#lokasi_pemadaman-edit').val(response.data.lokasi_pemadaman);
            $('#status_pemadaman-edit').val(response.data.status_pemadaman);
            $('#id_petugas-edit').val(response.data.id_petugas);
            //open modal
            $('#modal-edit').modal('show');
        }
    });
});
//action update post
$('#update').click(function(e) {
    e.preventDefault();
    e.stopPropagation();
    let post_id=$('#post_id').val()
    var form = new FormData();
    form.append("judul_pemadaman",$('#judul_pemadaman-edit').val());
    form.append("tgl_mulai_pemadaman", $('#tgl_mulai_pemadaman-edit').val());
    form.append("jam_mulai_pemadaman",$('#jam_mulai_pemadaman-edit').val());
    form.append("jam_selesai_pemadaman", $('#jam_selesai_pemadaman-edit').val());
    form.append("lokasi_pemadaman", $('#lokasi_pemadaman-edit').val());
    form.append("status_pemadaman", $('#status_pemadaman-edit').val());
    form.append("id_petugas", $('#id_petugas-edit').val());
    form.append("_method", "PUT");
//ajax
$.ajax({
    url: '{{url('api/pemadamans')}}/'+post_id,
    type: "POST",
    data: form,
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

        /*//data pemadaman
        let pemadaman = `
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
        //append to post data
        $(`#index_${response.data.id}`).replaceWith(pemadaman);*/

        //close modal
        $('#modal-edit').modal('hide');

        },
        error:function(error){
            console.log(error)
            if(error.responseJSON.judul_pemadaman[0]) {
                //show alert
                $('#alert-judul_pemadaman-edit').removeClass('d-none');
                $('#alert-judul_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-judul_pemadaman-edit').html(error.responseJSON.judul_pemadaman[0]);
            }
            if(error.responseJSON.tgl_mulai_pemadaman[0]) {
                //show alert
                $('#alert-tgl_mulai_pemadaman-edit').removeClass('d-none');
                $('#alert-tgl_mulai_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-tgl_mulai_pemadaman-edit').html(error.responseJSON.tgl_mulai_pemadaman[0]);
            }
            if(error.responseJSON.jam_mulai_pemadaman[0]) {
                //show alert
                $('#alert-jam_mulai_pemadaman-edit').removeClass('d-none');
                $('#alert-jam_mulai_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-jam_mulai_pemadaman-edit').html(error.responseJSON.jam_mulai_pemadaman[0]);
            }
            if(error.responseJSON.jam_selesai_pemadaman[0]) {
                //show alert
                $('#alert-jam_selesai_pemadaman-edit').removeClass('d-none');
                $('#alert-jam_selesai_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-jam_selesai_pemadaman-edit').html(error.responseJSON.jam_selesai_pemadaman[0]);
            }
            if(error.responseJSON.lokasi_pemadaman[0]) {
            //show alert
                $('#alert-lokasi_pemadaman-edit').removeClass('d-none');
                $('#alert-lokasi_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-lokasi_pemadaman-edit').html(error.responseJSON.lokasi_pemadaman[0]);
            }
            if(error.responseJSON.status_pemadaman[0]) {
                //show alert
                $('#alert-status_pemadaman-edit').removeClass('d-none');
                $('#alert-status_pemadaman-edit').addClass('d-block');
                //add message to alert
                $('#alert-status_pemadaman-edit').html(error.responseJSON.status_pemadaman[0]);
            }
            if(error.responseJSON.id_petugas[0]) {
            //show alert
            $('#alert-id_petugas-edit').removeClass('d-none');
            $('#alert-id_petugas-edit').addClass('d-block');
            //add message to alert
            $('#alert-id_petugas-edit').html(error.responseJSON.id_petugas[0]);
            }
        }
    });
});
</script>