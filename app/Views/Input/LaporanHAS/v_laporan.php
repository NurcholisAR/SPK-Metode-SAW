<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<title>Laporan Hasil Akir</title>
<?php

use App\Models\M_Penilaian;
use App\Models\M_jurusan;
// --------------------------------
$al = new M_Penilaian();
$fil = $al->filter();
// --------------------------------
$j = new M_jurusan();
$cek_s = $j->getJurusan();
?>
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Laporan Hasil Akhir</h4>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="form-inline">
                <label for="">Tahun :</label>
                <select name="tahun_masuk" id="tahun_masuk" onchange="filter()" class="form-control custom-select ml-2 mr-2">
                    <option value="">SEMUA DATA</option>
                    <?php foreach ($fil as $f) : ?>
                        <option value="<?= $f['tahun']; ?>"><?= $f['tahun']; ?></option>
                    <?php endforeach; ?>
                </select>
                <label class="ml-2" for="">Skor Min : </label>
                <div class="col-sm-1">
                    <!-- <p class="min"></p> -->
                    <input type="text" style="width: 70px;" readonly class="form-control" value="8">
                </div>
                <label class="ml-2" for="">Skor Max : </label>
                <div class="col-sm-1">
                    <!-- <div class="col-sm-1 mt-3"> -->
                    <!-- <p class="max"></p> -->
                    <input type="text" style="width: 70px;" readonly class="form-control" value="30">
                </div>
                <label class="ml-2" for="">Skor Tengah : </label>
                <div class="col-sm-2 ">
                    <?= form_open('LaporanHAS/cek_skor', ['class' => 'form_cek']); ?>
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <?php foreach ($cek_s as $m) {
                            echo '<input type="hidden" style="width: 70px;" name="id_skor" class="form-control" value="' . $m['id_jurusan'] . '" >';
                            echo '<input type="text" style="width: 70px;" name="skor" autocomplete="off" class="form-control" value="' . $m['skor_jurusan'] . '" >';
                        ?>
                        <?php } ?>
                        <button class="btn btn-primary btn-fil ml-2" type="submit">Simpan</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
            <div class="dropdown-divider"></div>
            <p class="card-text list_per"></p>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    $(document).ready(function() {
        filter()
    });

    function filter() {
        var tahun_masuk = $('#tahun_masuk').val();
        // console.log(tahun_masuk);
        $.ajax({
            url: "<?= base_url('LaporanHAS/list'); ?>",
            data: {
                tahun_masuk: tahun_masuk,
            },
            dataType: "json",
            success: function(response) {
                $('.list_per').html(response.data);
                // $('.min').html(response.min);
                // $('.max').html(response.max);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('.form_cek').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.btn-fil').attr('disable', 'disabled');
                    $('.btn-fil').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-fil').attr('disabled');
                    $('.btn-fil').html('Simpan');
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses
                    })
                    filter();
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            })
        })
    })
</script>
<?= $this->endSection(); ?>