<?php

namespace App\Controllers;

use App\Models\M_Kriteria;
use App\Models\M_Sub_Kriteria;

class Sub_Kriteria extends BaseController
{
    protected $M_Kriteria;
    protected $M_Sub_Kriteria;
    public function __construct()
    {
        $this->M_Kriteria = new M_Kriteria();
        $this->M_Sub_Kriteria = new M_Sub_Kriteria();
    }
    public function index()
    {
        return view('Input/Sub_Kriteria/v_sub_kriteria');
    }
    public function list_sub()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'sub_kriteria' => $this->M_Sub_Kriteria->join_kriteria()
            ];
            $tampil = [
                'data' => view('Input/Sub_Kriteria/list_sub', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function form_add()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'sub_kriteria' => $this->M_Sub_Kriteria->getSub()
            ];
            $tampil = [
                'data' => view('Input/Sub_Kriteria/modal_add', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }

    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kriteria' => [
                    'label' => 'Nama Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'nama_sub' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong!'
                    ]
                ],
                'nilai_sub' => [
                    'label' => 'Nilai Sub Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_kriteria' => $validation->getError('nama_kriteria'),
                        'nama_sub' => $validation->getError('nama_sub'),
                        'nilai_sub' => $validation->getError('nilai_sub')
                    ]
                ];
            } else {

                $save = [
                    'id_kriteria' => $this->request->getVar('nama_kriteria'),
                    'nama_sub_kriteria' => $this->request->getVar('nama_sub'),
                    'bobot_sub_kriteria' => $this->request->getVar('nilai_sub')
                ];
                $this->M_Sub_Kriteria->save($save);
                $pesan = [
                    'sukses' => 'Berhasil ditambahkan'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }

    public function form_edit()
    {
        if ($this->request->isAJAX()) {
            $id_sub_kriteria = $this->request->getVar('id_sub_kriteria');
            $sk = $this->M_Sub_Kriteria->getSub($id_sub_kriteria);

            $data = [
                'id_sub_kriteria' => $sk['id_sub_kriteria'],
                'id_kriteria' => $sk['id_kriteria'],
                'nama_sub_kriteria' => $sk['nama_sub_kriteria'],
                'bobot_sub_kriteria' => $sk['bobot_sub_kriteria'],
                'kriteria' => $this->M_Kriteria->getKriteria()
            ];
            $pesan = [
                'sukses' => view('Input/Sub_Kriteria/modal_edit', $data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kriteria' => [
                    'label' => 'Nama Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'nama_sub' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong!'
                    ]
                ],
                'bobot_sub_kriteria' => [
                    'label' => 'Nilai Sub Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak boleh kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_kriteria' => $validation->getError('nama_kriteria'),
                        'nama_sub' => $validation->getError('nama_sub'),
                        'bobot_sub_kriteria' => $validation->getError('bobot_sub_kriteria')
                    ]
                ];
            } else {
                $save = [
                    'id_kriteria' => $this->request->getVar('nama_kriteria'),
                    'nama_sub_kriteria' => $this->request->getVar('nama_sub'),
                    'bobot_sub_kriteria' => $this->request->getVar('bobot_sub_kriteria')
                ];
                $id_sub = $this->request->getVar('id_sub_kriteria');
                $this->M_Sub_Kriteria->update($id_sub, $save);
                $pesan = [
                    'sukses' => 'Berhasil ditambahkan'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }



    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_sub = $this->request->getVar('id_sub_kriteria');
            $this->M_Sub_Kriteria->delete($id_sub);
            $pesan = [
                'sukses' => 'Berhasil dihapus'
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
}
