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
                    <label for="name" class="control-label">Pertanyaan <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="pertanyaan" name="pertanyaan">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pertanyaan"></div>
                </div>
                <div class="form-group">
                    <label for="name" class="control-label">Jawaban <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="jawaban" name="jawaban">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jawaban"></div>
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
    data.append("pertanyaan", $('#pertanyaan').val());
    data.append("jawaban", $('#jawaban').val());
    //ajax
    $.ajax({
        url: '{{ url('api/faqs') }}',
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
            
            

            //close modal
            $('#modal-create').modal('hide');
        },
        
        error:function(error){
            for (const value of data.values()) {
                    console.log(value);
                }
                if(error.responseJSON.pertanyaan[0]) {
                    $('#alert-pertanyaan').removeClass('d-none');
                    $('#alert-pertanyaan').addClass('d-block');
                    $('#alert-pertanyaan').html(error.responseJSON.pertanyaan[0]);

                }
                if(error.responseJSON.jawaban[0]) {
                    $('#alert-jawaban').removeClass('d-none');
                    $('#alert-jawaban').addClass('d-block');
                    $('#alert-jawaban').html(error.responseJSON.jawaban[0]);

                }
                
        }
    });
});
</script>