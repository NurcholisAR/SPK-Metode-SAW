<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Sub_Kriteria extends Model
{
    protected $table = 'tbl_sub_kriteria';
    protected $primaryKey = 'id_sub_kriteria';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id_kriteria',
        'nama_sub_kriteria',
        'bobot_sub_kriteria'
    ];

    public function getSub($id_sub_kriteria = false)
    {
        if ($id_sub_kriteria == false) {
            return $this
                ->table('tbl_sub_kriteria')
                ->get()
                ->getResultArray();
        }
        return $this->where(['id_sub_kriteria' => $id_sub_kriteria])->first();
    }
    public function join_kriteria()
    {
        $builder = $this->table('tbl_sub_kriteria');
        $builder->select('*');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_sub_kriteria.id_kriteria', 'left');
        $builder->orderBy('tbl_kriteria.nama_kriteria');

        // $builder->where('tbl_sub_kriteria.id_kriteria', $id_kriteria);
        return $builder->get()->getResultArray();
    }
    public function group()
    {
        $builder = $this->table('tbl_sub_kriteria');
        $builder->select('*');
        $builder->join('tbl_kriteria', 'tbl_kriteria.id_kriteria = tbl_sub_kriteria.id_kriteria', 'left');
        $builder->groupBy('tbl_kriteria.id_kriteria');
        return $builder->get();
    }
    public function get_sub_kriteria($id_kriteria)
    {
        // $builder = $this->table('tbl_sub_kriteria');
        // $query =   $builder->getWhere(['id_kriteria' => $id_kriteria]);
        // return $query;

        $builder = $this->table('tbl_sub_kriteria');
        $builder->select('*');
        $builder->having('id_kriteria', $id_kriteria);
        return $builder->get()->getResultArray();
    }
}
