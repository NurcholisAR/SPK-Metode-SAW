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
                    <label class="col-sm-4 col-form-label">Tahun Masuk</label>
                    <div class="col-sm-8">
                        <select name="tahun_masuk" id="tahun_masuk" onchange="filter()" class="form-control custom-select">
                            <option value="" selected>--PILIH--</option>
                            <?php foreach ($alternatif as $t) : ?>
                                <option value="<?= $t['tahun']; ?>"><?= $t['tahun']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Alternatif</label>
                    <div class="col-sm-8">
                        <select style="width: 100% !important; flex: 1 1 auto;" name="nama_alternatif" id="nama_alternatif" class="form-control ">
                            <option value="" selected disabled>--PILIH--</option>
                        </select>
                        <div class="invalid-feedback errorNA">
                        </div>
                    </div>
                </div>
                <?php

                use App\Models\M_Sub_Kriteria;

                $M_Sub = new M_Sub_Kriteria();
                foreach ($kriteria as $k) {
                    $id_kriteria = $k['id_kriteria'];
                    $cek = $M_Sub->get_sub_kriteria($id_kriteria);
                    echo '<div class="form-group row">';
                    echo '<label style ="text-transform: capitalize;align-self:center" class="col-sm-4 col-form-label">' . $k['nama_kriteria'] . '</label>';
                    echo '<div class="col-sm-8">';
                    if (!empty($cek)) {
                        echo '<select id="kriteria[' . $id_kriteria . ']" name="kriteria[' . $id_kriteria . ']" class="form-control custom-select" required>';
                        echo '<option value="" selected disabled>--PILIH--</option>';
                        foreach ($cek as $c) {
                            echo '<option value="' . $c['bobot_sub_kriteria'] . '">' . $c['nama_sub_kriteria'] . '</option>';
                        }
                        echo '</select>';
                    } else {
                        // echo '<input type="number" id="kriteria[' . $id_kriteria . ']" name="kriteria[' . $id_kriteria . ']" class="form-control" >';
                        echo '<select id="kriteria[' . $id_kriteria . ']" name="kriteria[' . $id_kriteria . ']" class="form-control custom-select" required>';
                        echo '<option value="" selected disabled>--PILIH--</option>';
                        foreach ($Nilai as $r) {
                            echo '<option  value="' . $r['jum_nilai'] . '">' . $r['ket_nilai'] . '</option>';
                        }
                        echo '</select>';
                    }
                    echo '<div class="invalid-feedback errorNK">';
                    echo '</div>';
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
    function filter() {
        var tahun_masuk = $('#tahun_masuk').val();
        console.log(tahun_masuk);

        $.ajax({
            url: "<?= site_url('Penilaian/filter'); ?>",
            method: "POST",
            data: {
                tahun_masuk: tahun_masuk
            },
            // async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                for (i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].id_alternatif + '">' + data[i].nis_alternatif + " | " + data[i].nama_alternatif + '</option>';
                }
                $('#nama_alternatif').html(html);
                var nama = $('#nama_alternatif').val();
                console.log(nama);
            }
        });
    }

    $('document').ready(function() {
        filter();
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