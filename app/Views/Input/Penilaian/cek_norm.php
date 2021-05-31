<style>
    .btn-norm {
        background: transparent;
        border: transparent;
        padding: 0%;
        text-decoration: underline;
    }

    .btn-norm:hover {
        color: blue;
        cursor: pointer;
        text-decoration: underline;
    }

    strong {
        color: black;
        text-transform: capitalize
    }
</style>

<?php if ($check_null) { ?>
    <?= form_open('Penilaian/normalisasi', ['class' => 'form_norm']); ?>
    <div class="alert alert-warning">
        <strong><i class="ion-speakerphone"></i> Saat Ini ada nilai yang belum dinormalisasi.</strong>
        <button type="submit" class="btn btn-norm">Normalisasi Sekarang ?</button>
    </div>
    <?= form_close(); ?>
<?php } elseif ($check_ada) { ?>
    <div class="alert alert-success">
        <strong><i class="ion-checkmark-round"></i> Semua Nilai sudah dinormalisasi.</strong>
        <!-- <button type="submit" class="btn btn-primary btn-norm">proses</button> -->
    </div>
<?php } else { ?>
<?php } ?>

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<script>
    $('document').ready(function() {
        tampil_penilaian();
        $('.form_norm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btn-norm').attr('disable', 'disabled');
                    $('.btn-norm').html('Memproses <i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-norm').attr('disabled');
                    $('.btn-norm').html('Proses');
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.sukses
                    });
                    cek_norm();
                    tampil_penilaian();
                },
                error: function(xhr, ajaxOption, throwError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                }
            });
        })
    })
</script>