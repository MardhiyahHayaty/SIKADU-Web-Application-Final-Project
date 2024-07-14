<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA BERITA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formData" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label for="name" class="control-label">Judul Berita <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="judul_berita" name="judul_berita">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-judul_berita"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Isi Berita <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="isi_berita" name="isi_berita">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-isi_berita"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Foto Berita <span class="text-danger">*</span> </label>
                    <input type="file" class="form-control" id="foto_berita" name="foto_berita" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_berita"></div>
                </div>
                
                <div class="form-group">
                    <input type="hidden" class="form-control" id="id_petugas" name="id_petugas" value="{{ Auth::guard('admin')->user()->id }}">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_petugas"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary-berita" id="store">SIMPAN</button>
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
    data.append("judul_berita", $('#judul_berita').val());
    data.append("isi_berita", $('#isi_berita').val());
    data.append('foto_berita', $('input[id="foto_berita"]')[0].files[0]);
    //data.append("tgl_terbit_berita",$('#tgl_terbit_berita').val());
    data.append("id_petugas", $('#id_petugas').val());
    data.append("kata_sandi_petugas", $('#kata_sandi_petugas').val());
    //ajax
    $.ajax({
        url: '{{ url('api/beritas') }}',
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
            let berita = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.judul_berita}</td>
                    <td>${response.data.isi_berita}</td>
                    <td><img src="{{ url('storage/berita')}}${"/"+response.data.foto_berita}" width="50" height="50"></td>
                    <td>${response.data.tgl_terbit_berita}</td>
                    <td>${response.data.id_petugas}</td>
                    <td class="text-left">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                       
                    </td>
                </tr>
            `;
            //append to table
            $('#table-beritas').prepend(berita);
            //clear form
            $('#judul_berita').val('');
            $('#isi_berita').val('');
            $('#foto_berita').val('');
            $('#tgl_terbit_berita').val('');
            $('#id_petugas').val('');*/

            //close modal
            $('#modal-create').modal('hide');
        },
        
        error:function(error){
            for (const value of data.values()) {
                    console.log(value);
                }
                if(error.responseJSON.judul_berita[0]) {
                    $('#alert-judul_berita').removeClass('d-none');
                    $('#alert-judul_berita').addClass('d-block');
                    $('#alert-judul_berita').html(error.responseJSON.judul_berita[0]);

                }
                if(error.responseJSON.isi_berita[0]) {
                    $('#alert-isi_berita').removeClass('d-none');
                    $('#alert-isi_berita').addClass('d-block');
                    $('#alert-isi_berita').html(error.responseJSON.isi_berita[0]);

                }
                if(error.responseJSON.foto_berita[0]) {
                    $('#alert-foto_berita').removeClass('d-none');
                    $('#alert-foto_berita').addClass('d-block');
                    $('#alert-foto_berita').html(error.responseJSON.foto_berita[0]);

                }
                
                if(error.responseJSON.tgl_terbit_berita[0]) {
                    $('#alert-tgl_terbit_berita').removeClass('d-none');
                    $('#alert-tgl_terbit_berita').addClass('d-block');
                    $('#alert-tgl_terbit_berita').html(error.responseJSON.tgl_terbit_berita[0]);

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