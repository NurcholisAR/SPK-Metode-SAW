<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<title>Data Nilai</title>
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Data Nilai</h4>

        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">
                <button type="submit" class="btn btn-primary btn-flat btn_add">
                    <i class="fa fa-user-plus"></i> Tambah Data
                </button>
            </div>
            <div class="dropdown-divider"></div>
            <p class="card-text list_nilai">

            </p>
        </div>
    </div>
    <div class="v_modal" style="display: none;"></div>
</div>
<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    function tampil_nilai() {
        $.ajax({
            url: "<?= site_url('Nilai/list_nilai'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_nilai').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }
    $(document).ready(function() {
        tampil_nilai();
        $('.btn_add').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('Nilai/form_add'); ?>",
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