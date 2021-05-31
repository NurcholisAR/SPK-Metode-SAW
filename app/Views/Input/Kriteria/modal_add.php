<div class="modal fade" id="modal_add" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Kriteria/tambah', ['class' => 'form_add']); ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Kriteria</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria">
                        <div class="invalid-feedback errorNama_kriteria">

                        </div>
                    </div>
                </div>
                <style>
                    button.btn-quest {
                        background: transparent;
                        /* border-block: none; */
                        border: none;
                    }

                    button.btn-quest>i:hover {
                        color: blue;
                    }
                </style>
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label class="col-form-label">Tipe Kriteria</label>
                        <button class="btn-quest waves-effect" id="quest" type="button" role="button" data-toggle="popover" data-trigger="focus">
                            <i class="fa fa-question-circle-o"></i></button>
                    </div>
                    <div class="col-sm-8">
                        <select name="tipe_kriteria" id="tipe_kriteria" class="form-control custom-select">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                        </select>
                        <div class="invalid-feedback errorTK">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Bobot Kriteria</label>
                    <div class="input-group col-sm-8">
                        <select name="bobot_kriteria" id="bobot_kriteria" class="form-control custom-select">
                            <option value="" selected disabled>--PILIH--</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                        <div class="invalid-feedback errorBobot">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
    $('document').ready(function() {
        $('#quest').popover({
            placement: 'right',
            html: true,
            'animation': true,
            content: function() {
                return '<div class="title"><b>Benefit :</b></div><div class="content1">Jika Nilai Terbesar Adalah Terbaik</div>  <div class="dropdown-divider"></div> <div class="title2"><b>Cost :</b></div><div class="content2">Jika Nilai Terkecil Adalah Terbaik</div>';
            },
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
                        if (response.error.nama_kriteria) {
                            $('#nama_kriteria').addClass('is-invalid');
                            $('.errorNama_kriteria').html(response.error.nama_kriteria);
                        } else {
                            $('#nama_kriteria').removeClass('is-invalid');
                            $('.errorNama_kriteria').html('')
                        }
                        if (response.error.tipe_kriteria) {
                            $('#tipe_kriteria').addClass('is-invalid');
                            $('.errorTK').html(response.error.tipe_kriteria);
                        } else {
                            $('#tipe_kriteria').removeClass('is-invalid');
                            $('.errorTK').html('')
                        }
                        if (response.error.bobot_kriteria) {
                            $('#bobot_kriteria').addClass('is-invalid');
                            $('.errorBobot').html(response.error.bobot_kriteria);
                        } else {
                            $('#bobot_kriteria').removeClass('is-invalid');
                            $('.errorBobot').html('')
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses
                        });
                        tampil_kriteria();
                        $('#modal_add').modal('hide');
                    }

                }
            });
            return false;
        });
    });
</script>