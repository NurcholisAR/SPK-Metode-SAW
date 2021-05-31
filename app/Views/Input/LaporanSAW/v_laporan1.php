<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<?php

use App\Models\M_Penilaian;

$al = new M_Penilaian();

$fil = $al->filter();
?>
<title>Data Laporan SAW</title>
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Laporan Perhitungan SAW</h4>
        </div>
    </div>
</div>
<div class="col-md-12">
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
            </div>
            <div class="dropdown-divider"></div>
            <div class="hasil" style="padding: 30px; margin-top:-25px">

            </div>
            </p>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    $(document).ready(function() {
        filter();
        $('#nilai_kriteria').dataTable({
            "language": {
                "url": "/js/bahasa.json"
            },
            "responsive": true,
            "paging": false,
            "ordering": false,
            "searching": false,
            "info": false,
            "scrollX": true,
            "scrollY": '30vh',
            scrollCollapse: true,
        });
    });

    function filter() {
        var tahun_masuk = $('#tahun_masuk').val();
        console.log(tahun_masuk);
        $.ajax({
            url: "<?= base_url('LaporanSAW/list'); ?>",
            data: {
                tahun_masuk: tahun_masuk,
            },
            dataType: "json",
            success: function(response) {
                $('.hasil').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
</script>
<?= $this->endSection(); ?>