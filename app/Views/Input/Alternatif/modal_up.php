<div class="modal fade" id="modal_up" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unggah File Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('Alternatif/upload_file', ['class' => 'upload']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control" id="file_upload" name="file_upload">
                    <div class="invalid-feedback errorFile">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-save">Upload</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $('document').ready(function() {
        $('.upload').submit(function(e) {
            e.preventDefault();
            $.ajax({
                method: "post",
                url: $(this).attr('action'),
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btn-save').attr('disable', 'disabled');
                    $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-save').attr('disabled');
                    $('.btn-save').html('Upload');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.file_upload) {
                            $('#file_upload').addClass('is-invalid');
                            $('.errorFile').html(response.error.file_upload);
                        } else {
                            $('#file_upload').removeClass('is-invalid');
                            $('.errorFile').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Oops...',
                            text: response.sukses
                        })
                        tampil_data();
                        $('#modal_up').modal('hide');
                    }
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
            return false;
        })
    });
</script>