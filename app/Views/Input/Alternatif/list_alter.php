<table id="table_alter" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<link rel="stylesheet" href="/css/view.css">
<!-- <script src="<?= base_url() ?>/js/data.js"></script> -->
<script>
    $(document).ready(function() {
        list();
    });

    function list() {
        var table = $('#table_alter').DataTable({
            "processing": true,
            "serverSide": true,
            retrieve: true,
            lengthChange: true,
            info: true,
            autoWidth: false,
            responsive: true,
            language: {
                url: "/js/bahasa.json",
            },
            pagingType: "full_numbers",
            pageLength: 5,
            lengthMenu: [5, 10, 15, 30],
            "order": [

            ],
            "ajax": {
                "url": "<?= site_url('Alternatif/list_data'); ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0, 4],
                "orderable": false
            }],
        });
    }

    function detail(id_alternatif) {
        $.ajax({
            url: "<?= site_url('Alternatif/detail'); ?>",
            dataType: "json",
            data: {
                id_alternatif: id_alternatif
            },
            success: function(response) {
                $('.list_detail').html(response.data);
            },
            error: function(xhr, ajaxOption, throwError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
            }
        });
    }

    function edit(slug) {
        $.ajax({
            type: "post",
            url: "<?= site_url('Alternatif/form_edit'); ?>",
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
                    url: "<?= site_url('Alternatif/delete'); ?>",
                    data: {
                        id_alternatif: id_alternatif
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus',
                            });
                            tampil_data();
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