<style>
    table>thead>tr>th {
        text-align: center;
    }

    table>tbody>tr>td {
        text-align: center;
    }

    table.per {
        max-height: 10px;
    }
</style>
<h6 class="page-title">Hasil Akhir</h6>
<table class="table table-bordered table-striped display nowrap per" style="width: 100%;" id="table_jur">
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama Alternatif</th>
            <th>Skor</th>
            <th>Jurusan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alternatif as $r) : ?>
            <tr>
                <td><?= $r['nis_alternatif']; ?></td>
                <td><?= $r['nama_alternatif']; ?></td>
                <td><?= $r['hasil_norm']; ?></td>
                <td>
                    <?php if ($r['hasil_norm'] >= $r['skor_jurusan']) { ?>
                        IPA
                    <?php } elseif ($r['hasil_norm'] < $r['skor_jurusan'] and $r['hasil_norm'] != 0) { ?>
                        IPS
                    <?php } elseif ($r['hasil_norm'] == 0) { ?>
                        Belum Dinilai
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        var title = $('#tahun_masuk').val();
        var title2 = $("#tahun_masuk").children('option').map(function(i, e) {
            return e.title2 || e.innerText;
        }).get();
        console.log(title);
        console.log(title2);

        var table = $('#table_jur').DataTable({
            "language": {
                "url": "/js/bahasa.json"
            },
            info: true,
            // retrieve: true,
            autoWidth: true,
            "responsive": true,
            "scrollX": true,
            pagingType: "full_numbers",
            "lengthMenu": [
                [5, 15, 25, 50, -1],
                [5, 15, 25, 50, "SEMUA"]
            ],
            // pageLength: 5,
            // lengthMenu: [5, 10, 15, 30],
            buttons: ['excel',
                {
                    extend: 'print',
                    text: 'Print',
                    messageTop: function() {
                        if (title == 0) {
                            return 'Semua Data ';
                        } else {
                            return 'Data tahun Ajaran ' + title + '';
                        }

                    },
                    messageBottom: null,
                    exportOptions: {
                        columns: ':visible',
                        search: 'applied',
                        order: 'applied'
                    },
                    pageSize: 'LEGAL',
                    customize: function(win) {
                        var last = null;
                        var current = null;
                        var bod = [];

                        var css = '@page { size: portrait; }',
                            head = win.document.head || win.document.getElementsByTagName('head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(win.document.createTextNode(css));
                        }

                        head.appendChild(style);
                    }
                },
            ],
            dom: "<'row'<'col-md-3'l><'col-md-5 btn-exp'B><'col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });
        // table.buttons().container.appendTo('#table_wrapper .col-md-5:eq(0)');
    });
</script>