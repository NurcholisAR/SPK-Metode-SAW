<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<title>Data Laporan</title>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Bobot Kriteria</h4>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text list_kriteria" style="padding: 30px; margin-bottom:-30px; margin-top:-10px">

            </p>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Nilai Awal</h4>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text list_nilaiA">
            </p>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Normalisasi</h4>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text list_normalisasi">
            </p>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Rekomendasi Jurusan</h4>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-body">
            <p class="card-text list_peringkat">
            </p>
        </div>
    </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------- -->
<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    function tampil_kriteria() {
        $.ajax({
            url: "<?= site_url('Laporan/list_kriteria'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_kriteria').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function tampil_nilaiA(kelas_alternatif) {
        $.ajax({
            url: "<?= site_url('Laporan/list_nilaiA'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_nilaiA').html(response.sukses);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function tampil_normalisasi() {
        $.ajax({
            url: "<?= base_url('Laporan/list_normalisasi'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_normalisasi').html(response.sukses);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function tampil_peringkat() {
        $.ajax({
            url: "<?= base_url('Laporan/list_peringkat') ?>",
            dataType: "json",
            success: function(response) {
                $('.list_peringkat').html(response.sukses);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
    $(document).ready(function() {
        tampil_kriteria();
        tampil_nilaiA();
        tampil_normalisasi();
        tampil_peringkat();
    });
</script>

<?= $this->endSection(); ?>