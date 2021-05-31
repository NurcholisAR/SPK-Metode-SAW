<table id="table_id2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Kriteria</th>
            <th>Nama Sub Kriteria</th>
            <th>Nilai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($sub_kriteria as $sk) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $sk['nama_kriteria']; ?></td>
                <td><?= $sk['nama_sub_kriteria']; ?></td>
                <td><?= $sk['bobot_sub_kriteria'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="edit('<?= $sk['id_sub_kriteria']; ?>')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm tbn-flat btn-danger" onclick="hapus('<?= $sk['id_sub_kriteria']; ?>')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </tfoot>
</table>
<link rel="stylesheet" href="/css/view.css">
<script src="<?= base_url() ?>/js/data.js"></script>
<script>
    function edit(id_sub_kriteria) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Sub_Kriteria/form_edit'); ?>",
            data: {
                id_sub_kriteria: id_sub_kriteria
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.v_modal').html(response.sukses).show();
                    $('#modal_edit').modal('show');
                }
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function hapus(id_sub_kriteria) {
        Swal.fire({
            title: 'Hapus',
            text: 'Apakah anda ingin menghapus data ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Yidak'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('Sub_Kriteria/delete'); ?>",
                    data: {
                        id_sub_kriteria: id_sub_kriteria
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',

                            });
                            tampil_sub();
                        }
                    },
                    error: function(xhr, ajaxOption, throwError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                    }
                });
            }
        });
    }
</script>