<?php

use App\Models\M_Kriteria;
use App\Models\M_Sub_Kriteria;
use App\Models\M_Nilai;

$M_Kriteria = new M_Kriteria;
$M_N = new M_Nilai();
$Nilai = $M_N->get_nilai();
$kriteria = $M_Kriteria->getKriteria();
?>
<?php foreach ($kriteria as $kr) :
    $M_Sub = new M_Sub_Kriteria();
    $id_kriteria = $kr['id_kriteria'];
    $cek = $M_Sub->get_sub_kriteria($id_kriteria);
    if (!empty($cek)) {
        echo '<div class="form-group row">';
        echo '<h4 style ="color:red">' . $kr['nama_kriteria'] . '</h4>';
        foreach ($cek->getResult() as $row) {
            echo '<h4>' . $row->nama_sub_kriteria . '</h4>';
            echo '<select  name="kriteria[' . $kr['id_kriteria'] . '] "id="kriteria" class="form-control custom-select" required>';
            echo '<option value="" selected disabled>--PILIH--</option>';
            foreach ($Nilai as $n) {
                echo '<option value="' . $n['jum_nilai'] . '" >' . $n['ket_nilai'] . '</option>';
            }
            echo '</select>';
        }
    }
?>                
                    <?php endforeach ?>