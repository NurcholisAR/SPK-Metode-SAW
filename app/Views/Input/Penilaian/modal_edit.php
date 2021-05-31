<div class="modal fade" id="modal_edit" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Penilaian/update', ['class' => 'form_edit']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" name="id_alternatif" value="<?= $id_alternatif; ?>">
                <input type="hidden" name="id_kriteria" value="<?= $id_kriteria; ?>">
                <input type="hidden" name="id_penilaian" value="<?= $id_penilaian; ?>">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Alternatif</label>
                    <div class="col-sm-8">
                        <select name="nama_alternatif" id="nama_alternatif" class="form-control custom-select" readonly="readonly">
                            <option value="<?= $id_alternatif; ?>"><?= $nis_alternatif; ?> | <?= $nama_alternatif; ?></option>
                        </select>
                    </div>
                </div>
                <?php

                use App\Models\M_Penilaian;
                use App\Models\M_Sub_Kriteria;

                $M_P = new M_Penilaian();
                $MS = new M_Sub_Kriteria();
                ?>
                <?php
                foreach ($kriteria as $k) {
                    $id_kriteria = $k['id_kriteria'];
                    $x = $M_P->getPenilaian();
                    $sub = $MS->get_sub_kriteria($id_kriteria);
                    $ce = $M_P->get_nilai_p($id_kriteria, $id_alternatif);
                    if (!empty($Nilai)) {
                        echo '<div class="form-group row">';
                        echo '<label style ="text-transform: capitalize;" class="col-sm-4 col-form-label">' . $k['nama_kriteria'] . '</label>';
                        echo '<div class="col-sm-8">';
                        echo '<select id="kriteria"  name="kriteria[' . $k['id_kriteria'] . '] "class="form-control custom-select" required>';
                        echo '<option value="" selected disabled>--PILIH--</option>';
                        if (!empty($ce)) {
                            if (!empty($sub)) {
                                foreach ($sub as $c) {
                                    $n_lama = $ce['nilai_penilaian'];
                                    $ns = $c['bobot_sub_kriteria'];
                                    if ($n_lama == $ns) {
                                        echo '<option selected value="' . $c['bobot_sub_kriteria'] . '">' . $c['nama_sub_kriteria'] . '</option>';
                                    } else {
                                        echo '<option  value="' . $c['bobot_sub_kriteria'] . '">' . $c['nama_sub_kriteria'] . '</option>';
                                    }
                                }
                            } else {
                                foreach ($Nilai as $c) {
                                    $n_lama = $ce['nilai_penilaian'];
                                    $o = $c['ket_nilai'];
                                    $n = $c['jum_nilai'];
                                    if ($n_lama == $n) {
                                        echo '<option selected value="' . $n . '">' . $o . '</option>';
                                    } else {
                                        echo '<option  value="' . $n . '">' . $o . '</option>';
                                    }
                                }
                            }
                        } else {
                            foreach ($Nilai as $r) {
                                echo '<option  value="' . $r['jum_nilai'] . '">' . $r['ket_nilai'] . '</option>';
                            }
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
                <button type="submin" class="btn btn-primary btn-save">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!--  -->
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses
                    });
                    cek_norm();
                    tampil_penilaian();
                    $('#modal_edit').modal('hide');
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        });
    });
</script>