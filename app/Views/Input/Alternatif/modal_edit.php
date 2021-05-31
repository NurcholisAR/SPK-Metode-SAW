<!-- Modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Alternatif/update', ['class' => 'form_edit_alter']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <input type="hidden" name="id_alternatif" value="<?= $id_alternatif ?>">
                    <input type="hidden" name="slug" value="<?= $slug ?>">
                    <label class="col-sm-4 col-form-label">NIS</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nis_alternatif" name="nis_alternatif" value="<?= $nis_alternatif; ?>">
                        <div class="invalid-feedback errorNis_alternatif">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_alternatif" name="nama_alternatif" value="<?= $nama_alternatif; ?>">
                        <div class="invalid-feedback errorNama_alternatif">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="telp_alternatif">No Telepon</label>
                    <div class="col-sm-8">
                        <input type="text" name="telp_alternatif" id="telp_alternatif" class="form-control" value="<?= $telp_alternatif; ?>">
                        <div class="invalid-feedback errorTelp">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="jenis_kelamin">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        <div class="invalid-feedback errorJK">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="agama_alternatif">Agama</label>
                    <div class="col-sm-8">
                        <select id="agama_alternatif" name="agama_alternatif" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Konghuchu">Kong Hu Chu</option>
                        </select>
                        <div class="invalid-feedback errorAgama">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label " for="alamat_alternatif">Alamat</label>
                    <div class="col-sm-8">
                        <textarea class="form-control " id="alamat_alternatif" name="alamat_alternatif" rows="2"></textarea>
                        <div class="invalid-feedback errorAlamat">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label" for="tahun">Tahun Masuk</label>
                    <div class="col-sm-8">
                        <select name="tahun" id="tahun" class="form-control custom-select">
                            <option value="" disabled selected>--PILIH--</option>
                            <?php $thn = date('Y');
                            for ($i = date('Y') - 1; $i >= date('Y') - 5; $i--) {
                                $ta = $i . '/' . $thn; ?>
                                <?php if ($tahun == $ta) { ?>
                                    <option selected value="<?= $ta ?>"><?= $ta ?></option>
                                <?php } else { ?>
                                    <option value="<?= $ta ?>"><?= $ta ?></option>
                                <?php } ?>
                            <?php $thn--;
                            } ?>
                        </select>
                        <div class="invalid-feedback errorTahun">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submin" class="btn btn-primary btn-save">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    document.getElementById('jenis_kelamin').value = "<?= (old('jenis_kelamin')) ? old('jenis_kelamin') : $jk_alternatif ?>";
    document.getElementById('agama_alternatif').value = "<?= (old('agama_alternatif')) ? old('agama_alternatif') : $agama_alternatif ?>";
    document.getElementById('alamat_alternatif').value = "<?= (old('alamat_alternatif')) ? old('alamat_alternatif') : $alamat_alternatif ?> ";
</script>
<script>
    $('document').ready(function() {
        $('.form_edit_alter').submit(function(e) {
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
                        if (response.error.nis_alternatif) {
                            $('#nis_alternatif').addClass('is-invalid');
                            $('.errorNis_alternatif').html(response.error.nis_alternatif);
                        } else {
                            $('#nis_alternatif').removeClass('is-invalid');
                            $('.errorNis_alternatif').html('');
                        }
                        if (response.error.nama_alternatif) {
                            $('#nama_alternatif').addClass('is-invalid');
                            $('.errorNama_alternatif').html(response.error.nama_alternatif);
                        } else {
                            $('#nama_alternatif').removeClass('is-invalid');
                            $('.errorNama_alternatif').html('');
                        }

                        if (response.error.kelas_alternatif) {
                            $('#kelas_alternatif').addClass('is-invalid');
                            $('.errorKelas').html(response.error.kelas_alternatif);
                        } else {
                            $('#kelas_alternatif').removeClass('is-invalid');
                            $('.errorKelas').html('');
                        }

                        if (response.error.jurusan_alternatif) {
                            $('#jurusan_alternatif').addClass('is-invalid');
                            $('.errorJurusan').html(response.error.jurusan_alternatif);
                        } else {
                            $('#jurusan_alternatif').removeClass('is-invalid');
                            $('.errorJurusan').html('');
                        }

                        if (response.error.telp_alternatif) {
                            $('#telp_alternatif').addClass('is-invalid');
                            $('.errorTelp').html(response.error.telp_alternatif);
                        } else {
                            $('#telp_alternatif').removeClass('is-invalid');
                            $('.errorTelp').html('');
                        }

                        if (response.error.jenis_kelamin) {
                            $('#jenis_kelamin').addClass('is-invalid');
                            $('.errorJK').html(response.error.jenis_kelamin);
                        } else {
                            $('#jenis_kelamin').removeClass('is-invalid');
                            $('.errorJK').html('');
                        }

                        if (response.error.agama_alternatif) {
                            $('#agama_alternatif').addClass('is-invalid');
                            $('.errorAgama').html(response.error.agama_alternatif);
                        } else {
                            $('#agama_alternatif').removeClass('is-invalid');
                            $('.errorAgama').html('');
                        }

                        if (response.error.alamat_alternatif) {
                            $('#alamat_alternatif').addClass('is-invalid');
                            $('.errorAlamat').html(response.error.alamat_alternatif);
                        } else {
                            $('#alamat_alternatif').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }

                        if (response.error.tahun) {
                            $('#tahun').addClass('is-invalid');
                            $('.errorTahun').html(response.error.tahun);
                        } else {
                            $('#tahun').removeClass('is-invalid');
                            $('.errorTahun').html('');
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        })
                        tampil_data();
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