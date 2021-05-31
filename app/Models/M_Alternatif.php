<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Alternatif extends Model
{
    protected $table    = "tbl_alternatif";
    protected $primaryKey = "id_alternatif";
    // protected $useTimestamps = true;
    // protected $allowedFields = ['nama_alternatif', 'slug', 'kelas_alternatif_id', 'jurusan_alternatif_id', 'telp_alternatif', 'jk_alternatif', 'agama_alternatif', 'alamat_alternatif', 'skor_alternatif'];
    protected $allowedFields = ['nama_alternatif', 'nis_alternatif', 'slug', 'telp_alternatif', 'jk_alternatif', 'agama_alternatif', 'alamat_alternatif', 'hasil_norm', 'tahun'];

    public function getAlternatif($slug = false)
    {
        if ($slug == false) {
            return $this
                ->db->table('tbl_alternatif')
                ->get()
                ->getResultArray();
        }
        return $this->where(['slug' => $slug])->first();
    }

    public function getJoin($id_alternatif)
    {
        $builder = $this->table('tbl_alternatif');
        $builder->select('*');
        $builder->join('tbl_penilaian a', 'a.id_alternatif = tbl_alternatif.id_alternatif', 'left');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = a.id_kriteria', 'left');
        $builder->where(['tbl_alternatif.id_alternatif' => $id_alternatif]);
        return $builder->get();
    }

    public function delete_alter($id_alter)
    {
        $query = $this->db->query("DELETE * From tbl_alternatif where id_alternatif = '$id_alter'");
        return $query;
    }
    public function filter($filter_alter)
    {
        $builder = $this->table($this->table);
        $builder->select('*');
        $builder->Where(['tahun' => $filter_alter]);
        // $builder->groupBy('tbl_tahun.tahun_masuk');
        return $builder->get()->getResultArray();
    }
    public function tahun()
    {
        $builder = $this->table($this->table);
        $builder->select('tahun');
        return $builder->get()->getResultArray();
    }
    public function list_join()
    {
        $builder = $this->table('tbl_alternatif');
        $builder->select('*');
        $builder->groupBy('tahun');
        return $builder->get()->getResultArray();
    }
    // list chart
    // filter
    public function chart_1fa($a)
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif join tbl_jurusan where hasil_norm != 0 and hasil_norm >= skor_jurusan and tahun = '$a'");
        $total = count($query->getResultArray());
        return $total;
    }
    public function chart_1fb($a)
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif  join tbl_jurusan where hasil_norm != 0 and hasil_norm < skor_jurusan and tahun = '$a'");
        $total = count($query->getResultArray());
        return $total;
    }


    // non filter chart
    public function chart1a()
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif  join tbl_jurusan where hasil_norm >= skor_jurusan ");
        $total = count($query->getResultArray());
        return $total;
    }
    public function chart1b()
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif  join tbl_jurusan where hasil_norm != 0 and hasil_norm < skor_jurusan ");
        $total = count($query->getResultArray());
        return $total;
    }


    // list beranda filter
    public function jum_alter_f($a)
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif where tahun = '$a'");
        $total = count($query->getResultArray());
        return $total;
    }
    public function belum_dinilai_f($a)
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif where hasil_norm = 0 and tahun = '$a'");
        $total = count($query->getResultArray());
        return $total;
    }
    public function sudah_dinilai_f($a)
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif where hasil_norm > 0 and tahun = '$a'");
        $total = count($query->getResultArray());
        return $total;
    }

    // list beranda 
    public function jum_alter()
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif");
        $total = count($query->getResultArray());
        return $total;
    }
    public function belum_dinilai()
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif where hasil_norm = 0");
        $total = count($query->getResultArray());
        return $total;
    }
    public function sudah_dinilai()
    {
        $query = $this->db->query("SELECT id_alternatif FROM tbl_alternatif where hasil_norm > 0");
        $total = count($query->getResultArray());
        return $total;
    }

    // cari skor min dan max
    public function skor_min()
    {
        $query = $this->db->query("SELECT min(hasil_norm) as min from tbl_alternatif where hasil_norm != 0");
        return $query->getResultArray();
    }
    public function skor_minF($tahun)
    {
        $query = $this->db->query("SELECT min(hasil_norm) as min from tbl_alternatif where hasil_norm != 0 and tahun = '$tahun'");
        return $query->getResultArray();
    }
    public function skor_max()
    {
        $query = $this->db->query("SELECT max(hasil_norm) as max from tbl_alternatif where hasil_norm != 0");
        return $query->getResultArray();
    }
    public function skor_maxF($tahun)
    {
        $query = $this->db->query("SELECT max(hasil_norm) as max from tbl_alternatif where hasil_norm != 0 and tahun = '$tahun'");
        return $query->getResultArray();
    }
}
