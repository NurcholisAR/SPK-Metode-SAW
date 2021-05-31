<div class="modal fade" id="modal_add" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Penilaian/tambah', ['class' => 'form_add']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Alternatif</label>
                    <div class="col-sm-8">
                        <select style="width: 100% !important; flex: 1 1 auto;" name="nama_alternatif" id="nama_alternatif" class="form-control ">
                            <option value="" selected disabled>--PILIH--</option>
                            <?php

                            use App\Models\M_Penilaian;

                            $M_P = new M_Penilaian();
                            ?>
                            <?php foreach ($alternatif as $a) {
                                $id_alternatif = $a['id_alternatif'];
                            ?>

                                <option value="<?= $a['id_alternatif']; ?>"><?= $a['nis_alternatif']; ?> | <?= $a['nama_alternatif']; ?></option>

                            <?php }
                            ?>
                        </select>
                        <div class="invalid-feedback errorNA">
                        </div>
                    </div>
                </div>
                <?php

                use App\Models\M_Nilai;
                use App\Models\M_Sub_Kriteria;

                $Nilai = $M_N->get_nilai();
                ?>
                <?php
                foreach ($kriteria as $k) {
                    $M_Sub = new M_Sub_Kriteria();
                    $id_kriteria = $k['id_kriteria'];
                    $cek = $M_Sub->get_sub_kriteria($id_kriteria);
                    if (!empty($cek)) {
                        echo '<div class="form-group row">';
                        echo '<label style ="text-transform: capitalize;" class="col-sm-4 col-form-label">' . $k['nama_kriteria'] . '</label>';
                        echo '<div class="col-sm-8">';
                        echo '<select id="kriteria" name="kriteria[' . $k['id_kriteria'] . '] "class="form-control custom-select" required>';
                        echo '<option value="" selected disabled>--PILIH--</option>';
                        foreach ($cek->getResult() as $c) {
                            echo '<option value="' . $c->bobot_sub_kriteria . '">' . $c->nama_sub_kriteria . '</option>';
                        }
                        echo '</select>';
                        echo '<div class="invalid-feedback errorNK">';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                ?>
                <?php } ?>
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!-- <script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script> -->
<script>
    $('document').ready(function() {
        $('#nama_alternatif').select2({
            dropdownAutoWidth: true,
        });
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
                        if (response.error.nama_alternatif) {
                            $('#nama_alternatif').addClass('is-invalid');
                            $('.errorNA').html(response.error.nama_alternatif);
                        } else {
                            $('#nama_alternatif').addClass('is-invalid');
                            $('.errorNA').html(response.error.nama_alternatif);
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        });
                        cek_norm();
                        tampil_penilaian();
                        $('#modal_add').modal('hide');
                    }
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        });
    });
</script>