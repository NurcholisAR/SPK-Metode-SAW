<style>
    table>thead>tr>th {
        text-align: center;
    }

    table>tbody>tr>td {
        text-align: center;
    }
</style>
<h6 class="page-title">Rekomendasi Jurusan</h6>
<table class="table table-bordered table-striped display nowrap" style="width: 100%;" id="table_jur">
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama Alternatif</th>
            <th>Skor IPA</th>
            <th>Skor IPS</th>
            <th>Jurusan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alternatif as $r) : ?>
            <tr>
                <td><?= $r['nis_alternatif']; ?></td>
                <td><?= $r['nama_alternatif']; ?></td>
                <td><?= $r['hasil_ipa']; ?></td>
                <td><?= $r['hasil_ips']; ?></td>
                <td>
                    <?php if ($r['hasil_ipa'] > $r['hasil_ips']) { ?>
                        IPA
                    <?php } elseif ($r['hasil_ips'] > $r['hasil_ipa']) { ?>
                        IPS
                    <?php } elseif ($r['hasil_ipa'] == 0 && $r['hasil_ips'] == 0) { ?>
                        Belum Dinilai
                    <?php } elseif ($r['hasil_ips'] == $r['hasil_ipa']) { ?>
                        Terdapat Nilai yang Sama
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>