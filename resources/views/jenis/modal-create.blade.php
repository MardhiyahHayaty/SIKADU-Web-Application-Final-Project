<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA JENIS ADUAN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="formData" enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label for="name" class="control-label">Kategori Aduan <span class="text-danger">*</span> </label><br>
                    <select class="form-control" name="id_kategori" id="id_kategori" required>     
                        @foreach($kategoris as $kategori)
                        <option selected="selected"  value="{{$kategori->id}}">{{$kategori->nama_kategori}}</option>
                        @endforeach
                        <option selected="selected"  value="">--Pilih Kategori Aduan--</option>
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_kategori"></div>
                    <div id="tambahkan-link" style="text-align: right">Kategori aduan tidak tersedia? <a href="javascript:void(0)" id="btn-create-kategori">Tambahkan</a></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Jenis Aduan <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="nama_jenis_aduan" name="nama_jenis_aduan">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_jenis_aduan"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">OPD <span class="text-danger">*</span></label><br>
                    <select class="form-control" name="id_opd" id="id_opd" required>     
                        @foreach($opds as $opd)
                        <option selected="selected"  value="{{$opd->id}}">{{$opd->nama_opd}}</option>
                        @endforeach
                        <option selected="selected"  value="">--Pilih OPD--</option>
                    </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-id_opd"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Foto Jenis Aduan <span class="text-danger">*</span> </label>
                    <input type="file" class="form-control" id="foto_jenis_aduan" name="foto_jenis_aduan" >
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_jenis_aduan"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary-jenis" id="store">SIMPAN</button>
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
    data.append("id_kategori", $('#id_kategori').val());
    data.append("nama_jenis_aduan", $('#nama_jenis_aduan').val());
    data.append("id_opd", $('#id_opd').val());
    data.append('foto_jenis_aduan', $('input[id="foto_jenis_aduan"]')[0].files[0]);
    //ajax
    $.ajax({
        url: '{{ url('api/jenisa') }}',
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
            let jenis = `
                <tr id="index_${response.data.id}">
                    <td>${response.data.id_kategori}</td>
                    <td>${response.data.nama_jenis_aduan}</td>
                    <td>${response.data.id_opd}</td>
                    <td><img src="{{ url('storage/jenis')}}${"/"+response.data.foto_jenis_aduan}" width="30" height="30"></td>
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
            $('#table-jenisa').prepend(jenis);
            //clear form
            $('#id_kategori').val('');
            $('#nama_jenis_aduan').val('');
            $('#id_opd').val('');
            $('#foto_jenis_aduan').val('');*/

            //close modal
            $('#modal-create').modal('hide');
        },
        
        error:function(error){
            for (const value of data.values()) {
                    console.log(value);
                }
                if(error.responseJSON.id_kategori[0]) {
                    $('#alert-id_kategori').removeClass('d-none');
                    $('#alert-id_kategori').addClass('d-block');
                    $('#alert-id_kategori').html(error.responseJSON.id_kategori[0]);

                }
                if(error.responseJSON.nama_jenis_aduan[0]) {
                    $('#alert-nama_jenis_aduan').removeClass('d-none');
                    $('#alert-nama_jenis_aduan').addClass('d-block');
                    $('#alert-nama_jenis_aduan').html(error.responseJSON.nama_jenis_aduan[0]);

                }
                if(error.responseJSON.id_opd[0]) {
                    $('#alert-id_opd').removeClass('d-none');
                    $('#alert-id_opd').addClass('d-block');
                    $('#alert-id_opd').html(error.responseJSON.id_opd[0]);

                }
                if(error.responseJSON.foto_jenis_aduan[0]) {
                    $('#alert-foto_jenis_aduan').removeClass('d-none');
                    $('#alert-foto_jenis_aduan').addClass('d-block');
                    $('#alert-foto_jenis_aduan').html(error.responseJSON.foto_jenis_aduan[0]);

                }
        }
    });
});
</script>
@include('jenis.add-kategori')