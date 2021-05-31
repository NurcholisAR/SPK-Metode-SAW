<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Nilai extends Model
{
    protected $table = "tbl_nilai";
    protected $primaryKey = "id_nilai";
    protected $allowedFields = [
        'ket_nilai',
        'jum_nilai'
    ];

    public function get_nilai()
    {
        $builder = $this->table('tbl_nilai');
        $builder->select('*');
        return $builder->get()->getResultArray();
    }
    public function getNilai($id_nilai = false)
    {
        if ($id_nilai == false) {
            return $this
                ->db->table('tbl_nilai')
                ->get()
                ->getResultArray();
        }
        return $this->where(['id_nilai' => $id_nilai])->first();
    }
}
