<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<title>Data Penilaian</title>
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Data Penilaian</h4>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">
                <div class="row grid-col">
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-flat btn_add">
                            <i class="fa fa-user-plus"></i> Tambah Data
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <div class="cek">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown-divider" style="margin-top: -2vmin;"></div>
            <p class="card-text list_data mt-2">
            </p>
        </div>
    </div>
    <div class="v_modal" style="display: none;"></div>
</div>

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    function cek_norm() {
        $.ajax({
            url: "<?= site_url('Penilaian/cek_norm'); ?>",
            dataType: "json",
            success: function(response) {
                $('.cek').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function tampil_penilaian() {
        $.ajax({
            url: "<?= site_url('Penilaian/list_penilaian'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_data').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
    $(document).ready(function() {
        tampil_penilaian();
        cek_norm();
        $('.btn_add').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('Penilaian/form_add'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.v_modal').html(response.data).show();

                    $('#modal_add').modal('show');
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        });
    });
</script>



<?= $this->endSection(); ?>