<!-- Modal -->
<div class="modal fade" id="modal_add" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Nilai/tambah', ['class' => 'form_add']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Rentang Nilai</label>
                    <div class="col-sm-8">
                        <input class="form-control" autocomplete="off" type="text" name="ket_nilai" id="ket_nilai">
                        <div class="invalid-feedback errorKN">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Bobot Nilai</label>
                    <div class="input-group col-sm-8">
                        <select name="bobot_nilai" id="bobot_nilai" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <div class="invalid-feedback errorBobot_nilai">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('document').ready(function() {
        $('.form_add').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btn-save').attr('disable', 'disabled');
                    $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-save').attr('disabled');
                    $('.btn-save').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.ket_nilai) {
                            $('#ket_nilai').addClass('is-invalid');
                            $('.errorKN').html(response.error.ket_nilai);
                        } else {
                            $('#ket_nilai').removeClass('is-invalid');
                            $('.errorKN').html('')
                        }
                        if (response.error.bobot_nilai) {
                            $('#bobot_nilai').addClass('is-invalid');
                            $('.errorBobot_nilai').html(response.error.bobot_nilai);
                        } else {
                            $('#bobot_nilai').removeClass('is-invalid');
                            $('.errorBobot_nilai').html('')
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        });
                        tampil_nilai();
                        $('#modal_add').modal('hide');
                    }

                }
            });
            return false;
        });
    });
</script>