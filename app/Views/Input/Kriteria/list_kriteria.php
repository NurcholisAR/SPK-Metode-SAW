<table id="table_id2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kriteria</th>
            <th>Tipe Kriteria</th>
            <th>Bobot Kriteria</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        // $total =  100;
        foreach ($kriteria as $k) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $k['nama_kriteria']; ?></td>
                <td><?= $k['tipe_kriteria']; ?></td>
                <td><?= $k['bobot_kriteria'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="edit('<?= $k['slug']; ?>')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm tbn-flat btn-danger" onclick="hapus('<?= $k['id_kriteria']; ?>')"><i class="fa fa-trash"></i></button>
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
    function edit(slug) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Kriteria/form_edit'); ?>",
            data: {
                slug: slug
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

    function hapus(id_kriteria) {
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
                    url: "<?= site_url('Kriteria/delete'); ?>",
                    data: {
                        id_kriteria: id_kriteria
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Data gagal dihapus',
                            });
                            tampil_kriteria();
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                            });
                            tampil_kriteria();
                            jum_bbt();
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