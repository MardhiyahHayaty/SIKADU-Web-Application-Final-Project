<!-- Modal -->

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT DATA KATEGORI ADUAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="post_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Kategori Aduan <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_kategori-edit" required>
                           @foreach($kategoris as $kategori)
                            <option selected="selected"  value="{{$kategori->id}}">{{$kategori->nama_kategori}}</option>
                            @endforeach
                            <option selected="selected"  value=" ">--Pilih Kategori Aduan--</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_kategori-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Jenis Aduan <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="nama_jenis_aduan-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_jenis_aduan-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">OPD <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_opd-edit" required>
                           @foreach($opds as $opd)
                            <option selected="selected"  value="{{$opd->id}}">{{$opd->nama_opd}}</option>
                            @endforeach
                            <option selected="selected"  value=" ">--Pilih OPD--</option>
                        </select>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_opd-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Foto Jenis Aduan <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="foto_jenis_aduan-edit-input">
                        <a href="#" data-lightbox="image-1" data-title="Foto Jenis Aduan" id="foto_jenis_aduan-edit-link">
                            <img id="foto_jenis_aduan-edit-preview" width="50" height="50">
                        </a>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_jenis_aduan-edit"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-primary-jenis" id="update">SIMPAN</button>
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
        url: '{{url('api/jenisa')}}/'+post_id,
        type: "GET",
        cache: false,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success:function(response){
            //fill data to form
            $('#post_id').val(response.data.id);
            $('#id_kategori-edit').val(response.data.id_kategori);
            $('#nama_jenis_aduan-edit').val(response.data.nama_jenis_aduan);
            $('#id_opd-edit').val(response.data.id_opd);
            $('#foto_jenis_aduan-edit-preview').attr("src","{{ url('storage/jenis')}}"+"/"+response.data.foto_jenis_aduan);
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
    form.append("id_kategori",$('#id_kategori-edit').val());
    form.append("nama_jenis_aduan", $('#nama_jenis_aduan-edit').val());
    form.append("id_opd", $('#id_opd-edit').val());
    if ($('#foto_jenis_aduan-edit-input')[0].files[0]) {
        form.append("foto_jenis_aduan", $('#foto_jenis_aduan-edit-input')[0].files[0]);
    }
    form.append("_method", "PUT");
//ajax
$.ajax({
    url: '{{url('api/jenisa')}}/'+post_id,
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
        
        /*//data post
        let post = `
        <tr id="index_${response.data.id}">
        <td>${response.data.id_kategori}</td>
        <td>${response.data.nama_jenis_aduan}</td>
        <td>${response.data.id_opd}</td>
        <td>
        <img src="{{ url('storage/jenis')}}${"/"+response.data.foto_jenis_aduan}" width=30 height=30>
        </td>
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
error:function(error){
    console.log(error)
if(error.responseJSON.id_kategori[0]) {
//show alert
$('#alert-id_kategori-edit').removeClass('d-none');
$('#alert-id_kategori-edit').addClass('d-block');
//add message to alert
$('#alert-id_kategori-edit').html(error.responseJSON.id_kategori[0]);

}
if(error.responseJSON.nama_jenis_aduan[0]) {
//show alert
$('#alert-nama_jenis_aduan-edit').removeClass('d-none');
$('#alert-nama_jenis_aduan-edit').addClass('d-block');
//add message to alert

$('#alert-nama_jenis_aduan-edit').html(error.responseJSON.nama_jenis_aduan[0]);

}
if(error.responseJSON.id_opd[0]) {
//show alert
$('#alert-id_opd-edit').removeClass('d-none');
$('#alert-id_opd-edit').addClass('d-block');
//add message to alert

$('#alert-id_opd-edit').html(error.responseJSON.id_opd[0]);

}
if(error.responseJSON.foto_jenis_aduan[0]) {
//show alert
$('#alert-foto_jenis_aduan-edit').removeClass('d-none');
$('#alert-foto_jenis_aduan-edit').addClass('d-block');
//add message to alert

$('#alert-foto_jenis_aduan-edit').html(error.responseJSON.foto_jenis_aduan[0]);

}

}
});
});

// Preview image on file selection
$('#foto_jenis_aduan-edit-input').change(function() {
    const [file] = this.files;
    if (file) {
        const newSrc = URL.createObjectURL(file);
        $('#foto_jenis_aduan-edit-preview').attr('src', newSrc);
        $('#foto_jenis_aduan-edit-link').attr('href', newSrc);
    }
});
</script>