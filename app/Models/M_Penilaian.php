<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Penilaian extends Model

{
    protected $table = "tbl_penilaian";
    protected $primaryKey = "id_penilaian";
    protected $useTimestamps = true;
    protected $returnType     = 'array';
    protected $allowedFields = [
        'id_alternatif',
        'id_kriteria',
        'nilai_normalisasi',
        'hasil_normalisasi',
        'nilai_penilaian'
    ];
    protected $CI;

    public function filter_tahun($tahun)
    {
        // $builder = $this->table($this->table);
        // $builder->select('*');
        // $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        // $builder->Where(['tbl_alternatif.tahun' => $tahun]);
        // $builder->orderBy('tbl_penilaian.id_alternatif');
        // $builder->groupBy('tbl_alternatif.id_alternatif');
        // return $builder->get()->getResultArray();
        $query = $this->db->query("select * from tbl_alternatif join tbl_jurusan join tbl_penilaian on tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif  Where tbl_alternatif.tahun = '$tahun' group by tbl_alternatif.id_alternatif");
        return $query->getResultArray();
    }
    public function list_penilaian()
    {
        // $builder = $this->table('tbl_penilaian');
        // $builder->select('*');
        // $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        // $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_penilaian.id_kriteria', 'left');
        // $builder->orderBy('tbl_alternatif.nis_alternatif', 'asc');
        // $builder->groupBy('tbl_penilaian.id_alternatif');
        // return $builder->get()->getResultArray();
        $query = $this->db->query("SELECT * from tbl_alternatif  join tbl_jurusan join tbl_penilaian on tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif  group by tbl_alternatif.id_alternatif");
        return $query->getResultArray();
    }
    public function filter()
    {
        $builder = $this->table($this->table);
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->orderBy('tbl_penilaian.id_alternatif');
        $builder->groupBy('tbl_alternatif.tahun');
        return $builder->get()->getResultArray();
    }
    public function getJoinData()
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('*');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_penilaian.id_kriteria', 'left');
        return $builder->get()->getResultArray();
    }
    public function getPenilaian()
    {
        $data = $this->db->query("SELECT * FROM tbl_penilaian");
        return $data;
    }

    public function get_id_alter($id_alternatif)
    {
        if ($id_alternatif == false) {
            return $this
                ->table('tbl_alternatif')
                ->get()
                ->getResultArray();
        }
        return $this->where(['id_alternatif' => $id_alternatif])->first();
    }
    public function get_by_id($id_alternatif)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('*');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_penilaian.id_kriteria', 'left');
        $builder->where('tbl_penilaian.id_alternatif', $id_alternatif);
        return $builder->get();
    }
    public function get_detail($id_alternatif, $id_kriteria)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('*');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_penilaian.id_kriteria', 'left');
        $builder->where(['tbl_penilaian.id_alternatif' => $id_alternatif, 'tbl_penilaian.id_kriteria' => $id_kriteria]);
        return $builder->get();
    }
    public function get_nilai_p($id_kriteria, $id_alternatif)
    {
        if ($id_kriteria == false) {
            return $this
                ->table('tbl_penilaian')
                ->get()
                ->getResultArray();
        }
        return $this->where(['id_kriteria' => $id_kriteria, 'id_alternatif' => $id_alternatif])->first();
    }
    public function get_nil($id_kriteria, $id_alternatif)
    {
        if ($id_kriteria == false) {
            return $this
                ->table('tbl_penilaian')
                ->get()
                ->getResultArray();
        }
        return $this->where(['id_kriteria' => $id_kriteria, 'id_alternatif' => $id_alternatif, 'nilai_penilaian is null'])->first();
    }
    public function create($id_alternatif, $id_kriteria)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        date_default_timezone_set("Asia/Bangkok");
        $builder = $this->table('tbl_penilaian');
        $data = array();
        foreach ($id_kriteria as $key => $value) {
            $data[] = [
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $key,
                'nilai_penilaian' =>  $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $builder->insertBatch($data);
        // var_dump($data);
        $db->transComplete();
        return $builder;
    }
    public function edit($id_penilaian, $id_alternatif, $id_kriteria)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        date_default_timezone_set("Asia/Bangkok");
        $builder = $this->table('tbl_penilaian');
        $builder->where('id_alternatif', $id_alternatif);
        $builder->delete();
        $data = array();
        foreach ($id_kriteria as $key => $value) {
            $data[] = array(
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $key,
                'nilai_penilaian' => $value,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        $builder->where('id_alternatif', $id_alternatif);
        $builder->insertBatch($data, 'id_kriteria');
        // var_dump($data, );
        $db->transComplete();
        return $builder;
    }
    public function hapus($id_alternatif)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->where('id_alternatif', $id_alternatif);
        $builder->delete();
    }
    public function check_norm()
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('nilai_normalisasi');
        $builder->where('nilai_normalisasi = 0');
        return $builder->get()->getResultArray();
    }
    public function check_norm1()
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('nilai_normalisasi');
        return $builder->get()->getResultArray();
    }
    public function nilaiR($a)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->select('*');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_penilaian.id_kriteria', 'left');
        $builder->orderBy('tbl_penilaian.id_alternatif');
        $builder->where('tbl_penilaian.id_alternatif', $a);
        return $builder->get()->getResultArray();
    }
    public function nilai_max($b, $c)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->selectMax('nilai_penilaian', 'mnr1');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->where('tbl_alternatif.tahun', $c);
        $builder->where('tbl_penilaian.id_kriteria', $b);
        return $builder->get()->getResultArray();
    }

    public function nilai_min($b, $c)
    {
        $builder = $this->table('tbl_penilaian');
        $builder->selectMin('nilai_penilaian', 'mnr2');
        $builder->join('tbl_alternatif', 'tbl_alternatif.id_alternatif = tbl_penilaian.id_alternatif', 'left');
        $builder->where('tbl_alternatif.tahun', $c);
        $builder->where('id_kriteria', $b);
        return $builder->get()->getResultArray();
    }

    public function normalisasi($ia, $ik, $nn2, $nn3)
    {
        $query = $this->db->query("UPDATE tbl_penilaian SET 
            nilai_normalisasi = '$nn2', hasil_normalisasi = '$nn3'
            where id_alternatif = '$ia'and id_kriteria='$ik'");

        return $query;
    }
    function simpan_hasil($ia, $has)
    {
        $query = $this->db->query("UPDATE tbl_alternatif SET
            hasil_norm= '$has'
            WHERE id_alternatif = '$ia' ");
        return $query;
    }
    function hasil_norm($a)
    {
        $builder = $this->table($this->table);
        $builder->selectSum('hasil_normalisasi', 'bbn');
        $builder->where('id_alternatif', $a);
        return $builder->get()->getResultArray();
    }
}
