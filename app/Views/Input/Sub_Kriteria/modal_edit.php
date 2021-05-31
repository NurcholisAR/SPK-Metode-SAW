<div class="modal fade" id="modal_edit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Sub Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Sub_Kriteria/update', ['class' => 'form_edit']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Kriteria</label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id_sub_kriteria" id="id_sub_kriteria" value="<?= $id_sub_kriteria; ?>">
                        <select name="nama_kriteria" id="nama_kriteria" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <?php foreach ($kriteria as $k) : ?>
                                <option style="text-transform: capitalize;" value="<?= $k['id_kriteria']; ?>"><?= $k['nama_kriteria']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback errorNama_kriteria"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <input type="text" autocomplete="off" class="form-control" name="nama_sub" id="nama_sub" value="<?= $nama_sub_kriteria; ?>">
                        <div class="invalid-feedback errorNS"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nilai</label>
                    <div class="col-sm-8">
                        <select name="bobot_sub_kriteria" id="bobot_sub_kriteria" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <div class="invalid-feedback errorNilai_S"></div>
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
    document.getElementById('nama_kriteria').value = "<?= $id_kriteria; ?>";
    document.getElementById('bobot_sub_kriteria').value = "<?= (old('bobot_sub_kriteria')) ? old('bobot_sub_kriteria') : $bobot_sub_kriteria ?>";
</script>
<script>
    $('document').ready(function() {
        $('.form_edit').submit(function(e) {
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
                        if (response.error.nama_kriteria) {
                            $('#nama_kriteria').addClass('is-invalid');
                            $('.errorNama_kriteria').html(response.error.nama_kriteria);
                        } else {
                            $('#nama_kriteria').removeClass('is-invalid');
                            $('.errorNama_kriteria').html('')
                        }

                        if (response.error.nama_sub) {
                            $('#nama_sub').addClass('is-invalid');
                            $('.errorNS').html(response.error.nama_sub);
                        } else {
                            $('#nama_sub').removeClass('is-invalid');
                            $('.errorNS').html('')
                        }

                        if (response.error.bobot_sub_kriteria) {
                            $('#bobot_sub_kriteria').addClass('is-invalid');
                            $('.errorNilai_S').html(response.error.bobot_sub_kriteria);
                        } else {
                            $('#bobot_sub_kriteria').removeClass('is-invalid');
                            $('.errorNilai_S').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        });
                        tampil_sub();
                        $('#modal_edit').modal('hide');
                    }

                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
            return false;
        });
    });
</script>