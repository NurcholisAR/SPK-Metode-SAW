<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Kriteria extends Model
{
    protected $table = "tbl_kriteria";
    protected $primaryKey = "id_kriteria";
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_kriteria',
        'slug',
        'tipe_kriteria',
        'bobot_kriteria',
    ];
    public function getKriteria($slug = false)
    {
        if ($slug == false) {
            return $this
                ->table('tbl_kriteria')
                ->orderBy('id_kriteria')
                ->get()
                ->getResultArray();
        }
        return $this->where(['slug' => $slug])->first();
    }
    public function cek_jurusan($jurusan = false)
    {
        if ($jurusan == false) {
            return $this
                ->table('tbl_kriteria')
                ->get()
                ->getResultArray();
        }
        return $this->where(['jurusan_dari' => $jurusan])->first();
    }

    public function getKriteria_count()
    {
        $query = $this->db->query("SELECT * FROM tbl_kriteria");
        $total = count($query->getResultArray());
        return $total;
    }
    public function count_bobot()
    {
        $query = $this->db->query("SELECT SUM(bobot_kriteria) as bbn FROM tbl_kriteria ");
        return $query->getResultArray();
    }
    public function get_detail($id_alternatif)
    {
        $builder = $this->table('tbl_kriteria');
        $builder->select('*');
        $builder->join('tbl_penilaian', 'tbl_penilaian.id_kriteria = tbl_kriteria.id_kriteria', 'inner');
        $builder->where(['tbl_penilaian.id_alternatif' => $id_alternatif]);
        return $builder->get()->getResultArray();
    }
    public function get_krit_by_id($id_alternatif, $id_kriteria)
    {
        $builder = $this->table('tbl_kriteria');
        $builder->select('*');
        $builder->join('tbl_penilaian', 'tbl_penilaian.id_kriteria = tbl_kriteria.id_kriteria', 'inner');
        $builder->where('tbl_penilaian.id_alternatif', $id_alternatif);
        $builder->where('tbl_penilaian.id_kriteria', $id_kriteria);
        return $builder->get()->getResultArray();
    }
}
