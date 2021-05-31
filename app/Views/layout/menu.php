<?= $this->extend('layout/main'); ?>
<?= $this->section('menu'); ?>

<li class="has-submenu">
    <a href="/Home"><i class="mdi mdi-airplay"></i>Beranda</a>
</li>
<li class="has-submenu">
    <a href="/Alternatif"><i class="fa fa-user-circle-o"></i> Alternatif</a>
</li>
<li class="has-submenu">
    <a href="#"><i class="ti-layout-media-overlay"></i> Data Kriteria</a>
    <ul class="submenu">
        <li> <a href="/Kriteria">Kriteria</a></li>
        <li> <a href="/Sub_Kriteria">Sub Kriteria</a></li>
    </ul>
</li>
<!-- <li class="has-submenu">
    <a href="/Kriteria"><i class="ti-layout-media-overlay"></i> Kriteria</a>
</li> -->
<li class="has-submenu">
    <a href="/Nilai"><i class="ion-bookmark"></i> Nilai</a>
</li>
<li class="has-submenu">
    <a href="/Penilaian"><i class="ion-filing"></i> Penilaian</a>
</li>

<li class="has-submenu">
    <a href="#"><i class="ion-ios7-paper-outline"></i> Laporan</a>
    <ul class="submenu">
        <li> <a href="/LaporanSAW">Perhitungan SAW</a></li>
        <li> <a href="/LaporanHAS">Laporan Hasil Akhir</a></li>
    </ul>
</li>

<?= $this->endSection(); ?>