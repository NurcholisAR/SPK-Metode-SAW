<table id="table_alter" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Alternatif</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($list_penilaian as $p) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $p['nis_alternatif']; ?></td>
                <td><?= $p['nama_alternatif']; ?></td>
                <td><?= $p['tahun']; ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-info btn-flat" onclick="edit(<?= $p['id_alternatif']; ?>)"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger btn-flat" onclick="hapus(<?= $p['id_alternatif']; ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

<link rel="stylesheet" href="/css/view.css">
<script src="<?= base_url() ?>/js/data.js"></script>
<script>
    $(document).ready(function() {
        // list_data();
    });

    function list_data() {
        var table = $('#table_alter').DataTable({
            "processing": true,
            "serverSide": true,
            retrieve: true,
            lengthChange: true,
            info: true,
            autoWidth: false,
            responsive: true,
            searching: true,
            language: {
                url: "/js/bahasa.json",
            },
            pagingType: "full_numbers",
            pageLength: 5,
            lengthMenu: [5, 10, 15, 30],
            "order": [
                [1, 'asc']
            ],
            "ajax": {
                "url": "<?= site_url('Penilaian/list_data'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false
            }],
        });
    }

    function edit(id_alternatif) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Penilaian/form_edit'); ?>",
            data: {
                id_alternatif: id_alternatif
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

    function hapus(id_alternatif) {
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
                    url: "<?= site_url('Penilaian/hapus'); ?>",
                    data: {
                        id_alternatif,
                        id_alternatif
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil dihapus',
                        });
                        cek_norm();
                        tampil_penilaian();

                    },
                    error: function(xhr, ajaxOption, throwError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                    }
                });
            }
        });
    }
</script>