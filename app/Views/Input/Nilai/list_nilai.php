<table id="table_id2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Rentang Nilai</th>
            <th>Bobot Nilai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($nilai as $n) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td style="text-transform: capitalize;"><?= $n['ket_nilai']; ?></td>
                <td><?= $n['jum_nilai'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="edit('<?= $n['id_nilai']; ?>')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm tbn-flat btn-danger" onclick="hapus('<?= $n['id_nilai']; ?>')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<link rel="stylesheet" href="/css/view.css">
<script src="<?= base_url() ?>/js/data.js"></script>
<script>
    function edit(id_nilai) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Nilai/form_edit'); ?>",
            data: {
                id_nilai: id_nilai
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

    function hapus(id_nilai) {
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
                    url: "<?= site_url('Nilai/delete'); ?>",
                    data: {
                        id_nilai: id_nilai
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
                            jum();
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                            });
                            tampil_nilai();
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