<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>
<?= $this->section('isi'); ?>
<title>Data Alternatif</title>
<div class="col-sm-12">
    <div class="page-title-box">
        <div class="btn-group">
            <h4 class="page-title">Data Alternatif</h4>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="card mb-3">
        <div class="card-body list_detail">
            <div class="card-title mb-3">
                <button type="submit" class="btn btn-primary btn-flat btn_add">
                    <i class="fa fa-user-plus"></i> Tambah Data
                </button>
                <button type="submit" class="btn btn-primary btn-flat btn_up">
                    <i class="fa fa-upload"></i> Unggah File
                </button>
            </div>
            <div class="dropdown-divider"></div>
            <p class="card-text list_all">

            </p>
        </div>
    </div>
    <div class="v_modal" style="display: none;"></div>
</div>

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<script src="<?= base_url() ?>/js/jquery-1.7.2.min.js"></script>
<script>
    function tampil_data() {
        $.ajax({
            url: "<?= site_url('Alternatif/list_alter'); ?>",
            dataType: "json",
            success: function(response) {
                $('.list_all').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    $(document).ready(function() {
        tampil_data();
        $('.btn_add').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('Alternatif/form_add_alter'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.v_modal').html(response.data).show();
                    $('#modal_add_alter').modal('show');
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        });
        $('.btn_up').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= site_url('Alternatif/upload'); ?>",
                dataType: "json",
                success: function(response) {
                    $('.v_modal').html(response.data).show();

                    $('#modal_up').modal('show');
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>