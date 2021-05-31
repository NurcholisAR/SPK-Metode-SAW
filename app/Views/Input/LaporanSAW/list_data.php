<style>
    table>thead>tr>th {
        text-align: center;
    }

    table>tbody>tr>td {
        text-align: center;
    }

    table {
        max-height: 20px;
    }
</style>
<!-- Nav tabs -->
<ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link active" data-toggle="tab" href="#kriteria-1" role="tab">Kriteria</a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-toggle="tab" href="#nilai-1" role="tab">Nilai Awal</a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-toggle="tab" href="#normalisasi-1" role="tab">Normalisasi</a>
    </li>
    <li class="nav-item waves-effect waves-light">
        <a class="nav-link" data-toggle="tab" href="#saw-1" role="tab">Hasil SAW</a>
    </li>
</ul>
<div class="dropdown-divider"></div>
<!-- Tab panes -->
<div class="tab-content">
    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <div class="tab-pane p-2 active" id="kriteria-1" role="tabpanel">
        <h6 class="page-title">Bobot Kriteria</h6>
        <table id="nilai_kriteria" style="width: 100%;" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th colspan="<?= $kriteria_count ?>">Nama Kriteria</th>
                </tr>
                <tr>
                    <?php foreach ($kriteria as $k) : ?>
                        <th style="text-transform: capitalize;"><?= $k['nama_kriteria']; ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    foreach ($kriteria as $ks) : ?>
                        <td>
                            <?= $ks['bobot_kriteria']; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>

            </tbody>
        </table>
    </div>
    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <div class="tab-pane p-2" id="nilai-1" role="tabpanel">
        <h6 class="page-title">Nilai Awal</h6>
        <table id="nilai_nilai" class="table table-bordered table-striped display nowrap" cellspacing="0" style="width:100%;">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">Nama Alternatif</th>
                    <th colspan="<?= $kriteria_count; ?>">Kriteria</th>
                </tr>
                <tr>
                    <?php foreach ($kriteria as $k) : ?>
                        <th style="text-transform: capitalize;"><?= $k['nama_kriteria']; ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php

                use App\Models\M_Penilaian;

                $M_P = new M_Penilaian();
                ?>
                <?php foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $p['nama_alternatif'] ?></td>
                        <?php
                        $a = $p['id_alternatif'];
                        $nil = $M_P->nilaiR($a);
                        foreach ($nil as $nn) : ?>
                            <td><?= $nn['nilai_penilaian']; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <div class="tab-pane p-2" id="normalisasi-1" role="tabpanel">
        <h6 class="page-title">Normalisasi</h6>
        <table class="table table-bordered table-striped display nowrap" cellspacing="0" style="width: 100%;" id="table_norm">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">Nama Alternatif</th>
                    <th colspan="<?= $kriteria_count; ?>">Kriteria</th>
                </tr>
                <tr>
                    <?php foreach ($kriteria as $k) : ?>
                        <th style="text-transform: capitalize;"><?= $k['nama_kriteria']; ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($penilaian as $p) : ?>
                    <tr>
                        <td><?= $p['nama_alternatif']; ?></td>
                        <?php
                        $a = $p['id_alternatif'];
                        $nil = $M_P->nilaiR($a);
                        foreach ($nil as $nn) : ?>
                            <td><?= $nn['nilai_normalisasi']; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- ----------------------------------------------------------------------------------------------------------- -->
    <div class="tab-pane p-2" id="saw-1" role="tabpanel">
        <h6 class="page-title">Hasil Perhitungan SAW</h6>
        <table class="table table-bordered table-striped display nowrap" cellspacing="0" style="width: 100%;" id="table_jur">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Alternatif</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alternatif as $r) : ?>
                    <tr>
                        <td><?= $r['nis_alternatif']; ?></td>
                        <td><?= $r['nama_alternatif']; ?></td>
                        <td><?= $r['hasil_norm']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .btn-exp {
        text-align: center;
    }

    .btn-exp::before {
        content: "Cetak: "
    }
</style>
<script>
    $(document).ready(function() {
        var title = $('#tahun_masuk').val();
        var title2 = $("#tahun_masuk").children('option').map(function(i, e) {
            return e.title2 || e.innerText;
        }).get();
        console.log(title);
        console.log(title2);

        var table = $('table.display').DataTable({
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