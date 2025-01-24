<!-- resources/views/faq/update.blade.php -->

<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData_edit" method="post">
                    @csrf
                    <input type="hidden" id="faq_id">
                    <div class="form-group">
                        <label for="pertanyaan" class="control-label">Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="pertanyaan-edit">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pertanyaan-edit"></div>
                    </div>
                    <div class="form-group">
                        <label for="jawaban" class="control-label">Jawaban <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="jawaban-edit" rows="4"></textarea>
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jawaban-edit"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary-berita" id="update">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Button edit FAQ event
    $('body').on('click', '#btn-edit-faq', function () {
        let faq_id = $(this).data('id');

        // Fetch detail FAQ with AJAX
        $.ajax({
            url: '{{ url('api/faqs') }}/' + faq_id,
            type: "GET",
            cache: false,
            success: function(response) {
                // Fill data to form
                $('#faq_id').val(response.data.id);
                $('#pertanyaan-edit').val(response.data.pertanyaan);
                $('#jawaban-edit').val(response.data.jawaban);

                // Open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    // Action update FAQ
    $('#update').click(function(e) {
        e.preventDefault();
        let faq_id = $('#faq_id').val();

        var form = {
            pertanyaan: $('#pertanyaan-edit').val(),
            jawaban: $('#jawaban-edit').val(),
            _method: "PUT",
            _token: $('input[name=_token]').val()
        };

        // AJAX
        $.ajax({
            url: '{{ url('api/faqs') }}/' + faq_id,
            type: "POST",
            data: form,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                    location.reload();
                });

                setTimeout(function() {
                    location.reload();
                }, 3000);

                $('#modal-edit').modal('hide');
            },
            error: function(error) {
                if (error.responseJSON.pertanyaan) {
                    $('#alert-pertanyaan-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.pertanyaan[0]);
                }

                if (error.responseJSON.jawaban) {
                    $('#alert-jawaban-edit').removeClass('d-none').addClass('d-block').html(error.responseJSON.jawaban[0]);
                }
            }
        });
    });
</script>
