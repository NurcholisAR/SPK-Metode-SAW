<link rel="stylesheet" href="/css/detail.css">
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline ml-3">
            <div class="card-body box-profile">
                <div class="text-center">
                    <?= '<img class="profile-user-img img-fluid img-circle" alt="User profile picture" src= "' . ($jk_alternatif == 'L' ? '/img/man-student.png' : '/img/woman-student.png') . '">' ?>
                </div>
                <h3 class="profile-username text-center"><?= $nama_alternatif; ?></h3>
                <ul class="list-group list-group-unbordered ">
                    <li class="list-group-item">
                        <strong>
                            <?= '<i class = "fa ' . ($jk_alternatif == 'L' ? 'fa-male' : 'fa-female') . '"> </i>' ?>
                            Jenis Kelamin</strong>
                        <p class="text-muted">
                            <?= ($jk_alternatif == 'L') ? 'Laki-Laki' : 'Perempuan'  ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="typcn typcn-contacts"></i> Agama</strong>
                        <p class="text-mutted">
                            <?= $agama_alternatif; ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fa fa-phone"></i> Telp</strong>
                        <p class="text-mutted">
                            <?= $telp_alternatif; ?>
                        </p>
                    </li>
                    <li class="list-group-item">
                        <strong><i class="fa fa-map-marker mr-1"></i> Alamat</strong>
                        <p class="text-muted">
                            <?= $alamat_alternatif; ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <?php

    use App\Models\M_Kriteria;

    $M_P = new M_Kriteria();

    ?>
    <div class="col-md-6">
        <div class="card card-primary card-outline ml-3">
            <div class="card-header p-2">
                <h5>Hasil Perhitungan</h5>
            </div><!-- /.card-header -->
            <div class="card-body">
                <!-- Post -->
                <form class="form-horizontal">
                    <?php if (!empty($hasil_norm)) { ?>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-6 col-form-label">Nilai Normalisasi</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputName" readonly value="<?= $hasil_norm ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-6 col-form-label">Rekomendasi Jurusan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputName" readonly value="<?= ($hasil_norm > 20) ? 'IPA' : 'IPS' ?>">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-6 col-form-label">Nilai Normalisasi</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputName" readonly placeholder="Belum Dinilai">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-6 col-form-label">Rekomendasi Jurusan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="inputName" readonly placeholder="Belum Dinilai">
                            </div>
                        </div>
                    <?php } ?>
                </form>
                <!-- /.post -->
                <div class="dropdown-divider"></div>
            </div>
            <div class="card-footer">
                <a href="/Alternatif" class="btn btn-secondary waves-effect btn_back"><i class="fa fa-reply"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>