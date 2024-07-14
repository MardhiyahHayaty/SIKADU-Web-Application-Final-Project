<!-- Modal -->

<div class="modal fade" id="modal-create-kategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA KATEGORI ADUAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDataKategori" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Kategori Aduan Baru <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_kategori"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Foto Kategori <span class="text-danger">*</span> </label>
                        <input type="file" class="form-control" id="foto_kategori" name="foto_kategori">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-foto_kategori"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button class="btn btn-primary-jenis" id="storeKategori">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    //button create post event
    $('body').on('click', '#btn-create-kategori', function() {
        //close modal jenis
        $('#modal-create').modal('hide');
        //open modal
        $('#modal-create-kategori').modal('show');
    });
    //action create post
    $('#formDataKategori').unbind('submit').bind('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = new
        FormData(document.getElementById("formData"));
        data.append("nama_kategori", $('#nama_kategori').val());
        data.append('foto_kategori', $('input[id="foto_kategori"]')[0].files[0]);

        // Disable the submit button to prevent multiple submissions
        $('#storeKategori').prop('disabled', true);

        //ajax
        $.ajax({
            url: '{{ url('api/kategoris') }}',
            type: "POST",
            data: data,
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
                });

                //clear form
                $('#nama_kategori').val('');
                $('#foto_kategori').val('');
                //close modal kategori
                $('#modal-create-kategori').modal('hide');
                // Enable the submit button
                $('#storeKategori').prop('disabled', false);
                //re-open modal jenis
                $('#modal-create').modal('show');

            },

            error: function(error) {
                for (const value of data.values()) {
                    console.log(value);
                }
                if (error.responseJSON.nama_kategori[0]) {
                    $('#alert-nama_kategori').removeClass('d-none');
                    $('#alert-nama_kategori').addClass('d-block');
                    $('#alert-nama_kategori').html(error.responseJSON.nama_kategori[0]);

                }
                if(error.responseJSON.foto_kategori[0]) {
                    $('#alert-foto_kategori').removeClass('d-none');
                    $('#alert-foto_kategori').addClass('d-block');
                    $('#alert-foto_kategori').html(error.responseJSON.foto_kategori[0]);

                }
            }
        });
    });
</script>