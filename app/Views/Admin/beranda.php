<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<?php
$session = \Config\Services::session();
?>
<link rel="stylesheet" href="<?= base_url() ?>/css/ribbon.css">
<?php

use App\Models\M_Alternatif;
use App\Models\M_Kriteria;
use App\Models\M_Penilaian;

$al = new M_Alternatif();
$mk = new M_Kriteria();
$mp = new M_Penilaian();


$jk = $mk->getKriteria_count();
$fil = $mp->filter();
?>
<title>Beranda</title>
<div class="col-md-12">
    <!-- RIBBON 1 -->
    <div class="container one">
        <div class="bk l">
            <div class="arrow top"></div>
            <div class="arrow bottom"></div>
        </div>

        <div class="skew l"></div>

        <div class="main">
            <div>
                <h1>
                    <span class="typewrite" data-period="2000" data-type='[ "Selamat Datang <?= $session->get('nama_user'); ?> Di halaman Sistem pendukung keputusan", "pemilihan jurusan menggunakan metode Simple Additive Weighting" ]'>
                        <span class="wrap"></span>
                    </span>
                </h1>
            </div>
        </div>

        <div class="skew r"></div>

        <div class="bk r">
            <div class="arrow top"></div>
            <div class="arrow bottom"></div>
        </div>

    </div>
</div>
<!-- table -->
<style>
    .kartu {
        margin-top: 4vmin;
    }
</style>
<div class="col-md-6 col-lg-6 col-xl-3 kartu">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class="col-3 align-self-center">
                    <div class="round">
                        <i class="mdi mdi-account-multiple"></i>
                    </div>
                </div>
                <div class="col-8 text-center">
                    <div class="m-l-10">
                        <h5 class="mt-0 round-inner num">
                            <span class="alter"></span>
                        </h5>
                        <p class="mb-0 text-muted">Total Data Alternatif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-6 col-xl-3 kartu">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class="col-3 align-self-center">
                    <div class="round">
                        <i class="mdi mdi-account-multiple-minus"></i>
                    </div>
                </div>
                <div class="col-8 align-self-center text-center">
                    <div class="m-l-10">
                        <h5 class="mt-0 round-inner num">
                            <span class="belum"></span>
                        </h5>
                        <p class="mb-0 text-muted">Data Alternatif Belum Dinilai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-6 col-xl-3 kartu">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class="col-3 align-self-center">
                    <div class="round">
                        <i class="mdi mdi-account-multiple-plus"></i>
                    </div>
                </div>
                <div class="col-8 text-center">
                    <div class="m-l-10">
                        <h5 class="mt-0 round-inner num">
                            <span class="sudah"></span>
                        </h5>
                        <p class="mb-0 text-muted">Data Alternatif Sudah Dinilai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-lg-6 col-xl-3 kartu">
    <div class="card m-b-30">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class="col-3 align-self-center">
                    <div class="round">
                        <i class="ti-layout-media-overlay"></i>
                    </div>
                </div>
                <div class="col-8 text-center">
                    <div class="m-l-10 ">
                        <h5 class="mt-0 round-inner num">
                            <span class="counter"><?= $jk; ?></span>
                        </h5>
                        <p class="mb-0 text-muted">Total Data Kriteria</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Table -->
<!-- chart -->

<div class="col-md-12 col-lg-12 col-xl-12">
    <div class="card m-b-30">
        <div class="card-header p-2">
            <div class="form-inline ml-3">
                <label for="">Tahun :</label>
                <select name="tahun_masuk" id="tahun_masuk" onchange="filter()" class="form-control custom-select ml-2 mr-2">
                    <option value="">SEMUA DATA</option>
                    <?php foreach ($fil as $f) : ?>
                        <option value="<?= $f['tahun']; ?>"><?= $f['tahun']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div id="container" class="chart1" style="width:100%; height:300px;"></div>
        </div>
    </div>
</div>
<!-- End chart -->
<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    $(document).ready(function() {
        filter();

    });

    function filter() {
        var tahun_masuk = $('#tahun_masuk').val();
        $.ajax({
            url: "<?= site_url('Home/list_kartu'); ?>",
            type: "post",
            data: {
                tahun_masuk: tahun_masuk
            },
            dataType: "json",
            success: function(response) {
                $('.alter').html(response.alter);
                $('.belum').html(response.belum);
                $('.sudah').html(response.sudah);
                $('.chart1').html(response.chart1);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
</script>

<?= $this->endSection(); ?>