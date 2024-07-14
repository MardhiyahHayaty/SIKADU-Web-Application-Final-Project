<!-- Modal -->

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT DATA BERITA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="post_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Judul Berita <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="judul_berita-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-judul_berita-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Isi Berita <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" id="isi_berita-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-isi_berita-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Foto Berita <span class="text-danger">*</span> </label>
                        <input type="file" class="form-control" id="foto_berita-edit-input">
                        <a href="#" data-lightbox="image-1" data-title="Foto Berita" id="foto_berita-edit-link">
                            <img id="foto_berita-edit-preview" width="50" height="50">
                        </a>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_berita-edit"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tanggal Terbit <span class="text-danger">*</span> </label>
                        <input type="datetime-local" class="form-control" id="tgl_terbit_berita-edit" style="background-color: #EFF2F5;" readonly>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tgl_terbit_berita-edit"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_petugas-edit" name="id_petugas-edit" value="{{ Auth::guard('admin')->user()->id }}">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_petugas-edit"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                    <button type="submit" class="btn btn-primary-berita" id="update">SIMPAN</button>
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
        url: '{{url('api/beritas')}}/'+post_id,
        type: "GET",
        cache: false,
        success:function(response){
            //fill data to form
            $('#post_id').val(response.data.id);
            $('#judul_berita-edit').val(response.data.judul_berita);
            $('#isi_berita-edit').val(response.data.isi_berita);
            $('#foto_berita-edit-preview').attr("src","{{ url('storage/berita')}}"+"/"+response.data.foto_berita);
            $('#tgl_terbit_berita-edit').val(response.data.tgl_terbit_berita);
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
    form.append("judul_berita",$('#judul_berita-edit').val());
    form.append("isi_berita", $('#isi_berita-edit').val());
    if ($('#foto_berita-edit-input')[0].files[0]) {
        form.append("foto_berita", $('#foto_berita-edit-input')[0].files[0]);
    }
    
    form.append("tgl_terbit_berita", $('#tgl_terbit_berita-edit').val());
    form.append("id_petugas", $('#id_petugas-edit').val());
    form.append("_method", "PUT");
//ajax
$.ajax({
    url: '{{url('api/beritas')}}/'+post_id,
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
        let berita = `
        <tr id="index_${response.data.id}">
        <td>${response.data.judul_berita}</td>
        <td>${response.data.isi_berita}</td>
        <td>
        <img src="{{ url('storage/berita')}}${"/"+response.data.foto_berita}" width=50 height=50>
        </td>
        <td>${response.data.tgl_terbit_berita}</td>
        <td>${response.data.id_petugas}</td>
        <td class="text-left">
            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
        
        </td>
        </tr>
        `;
//append to post data
$(`#index_${response.data.id}`).replaceWith(berita);*/

//close modal
$('#modal-edit').modal('hide');

},
error:function(error){
    console.log(error)
if(error.responseJSON.judul_berita[0]) {
//show alert
$('#alert-judul_berita-edit').removeClass('d-none');
$('#alert-judul_berita-edit').addClass('d-block');
//add message to alert
$('#alert-judul_berita-edit').html(error.responseJSON.judul_berita[0]);

}
if(error.responseJSON.isi_berita[0]) {
//show alert
$('#alert-isi_berita-edit').removeClass('d-none');
$('#alert-isi_berita-edit').addClass('d-block');
//add message to alert

$('#alert-isi_berita-edit').html(error.responseJSON.isi_berita[0]);

}
if(error.responseJSON.foto_berita[0]) {
//show alert
$('#alert-foto_berita-edit').removeClass('d-none');
$('#alert-foto_berita-edit').addClass('d-block');
//add message to alert

$('#alert-foto_berita-edit').html(error.responseJSON.foto_berita[0]);
}

if(error.responseJSON.tgl_terbit_berita[0]) {
//show alert
$('#alert-tgl_terbit_berita-edit').removeClass('d-none');
$('#alert-tgl_terbit_berita-edit').addClass('d-block');
//add message to alert

$('#alert-tgl_terbit_berita-edit').html(error.responseJSON.tgl_terbit_berita[0]);

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

// Preview image on file selection
$('#foto_berita-edit-input').change(function() {
    const [file] = this.files;
    if (file) {
        const newSrc = URL.createObjectURL(file);
        $('#foto_berita-edit-preview').attr('src', newSrc);
        $('#foto_berita-edit-link').attr('href', newSrc);
    }
});
</script>