<?php

namespace App\Models;

use CodeIgniter\Model;

class M_jurusan extends Model
{
  protected $table    = "tbl_jurusan";
  protected $primaryKey = "id_jurusan";
  protected $allowedFields = ['skor_jurusan'];

  public function getJurusan()
  {
    $query = $this->db->query("SELECT * from tbl_jurusan");
    return $query->getResultArray();
  }

  public function jurusan_f($tahun)
  {
    $query = $this->db->query("SELECT * from tbl_alternatif as a join tbl_jurusan as b where a.hasil_norm !=0 and a.tahun = '$tahun'");
    return $query;
  }
}
