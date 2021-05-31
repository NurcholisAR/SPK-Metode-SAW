<?php

namespace App\Controllers;

use App\Models\M_Kriteria;
use App\Models\M_Sub_Kriteria;

class Kriteria extends BaseController
{
    protected $M_Kriteria;
    protected $M_Sub_Kriteria;
    public function __construct()
    {
        $this->M_Sub_Kriteria = new M_Sub_Kriteria();
        $this->M_Kriteria = new M_Kriteria();
    }
    // ---------------------------------------------------    VIEW   --------------------------------------------------------------------
    public function index()
    {
        return view('Input/Kriteria/v_kriteria');
    }
    public function jum_bbt()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'kriteria' => $this->M_Kriteria->count_bobot()
            ];
            $tampil = [
                'data' => view('Input/Kriteria/btn_bbt', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_kriteria()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kriteria' => $this->M_Kriteria->getKriteria()
            ];
            $tampil = [
                'data' => view('Input/Kriteria/list_kriteria', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    ADD   --------------------------------------------------------------------
    public function form_add()
    {
        if ($this->request->isAJAX()) {
            $tampil = [
                'data' => view('Input/Kriteria/modal_add')
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function tambah()
    {
        if ($this->request->isAJAX()) {
            helper('form');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kriteria' => [
                    'label' => 'Nama Mapel',
                    'rules' => 'required|is_unique[tbl_kriteria.nama_kriteria]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ],
                'tipe_kriteria' => [
                    'label' => 'Tipe Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'bobot_kriteria' => [
                    'label' => 'Bobot Kriteria',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'numeric' => '{field} Harus Diisi dengan Angka!'
                    ]
                ],
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_kriteria' => $validation->getError('nama_kriteria'),
                        'tipe_kriteria' => $validation->getError('tipe_kriteria'),
                        'bobot_kriteria' => $validation->getError('bobot_kriteria'),
                    ]
                ];
            } else {
                $slug = url_title($this->request->getVar('nama_kriteria'), '-', true);
                $save = [
                    'nama_kriteria' => $this->request->getVar('nama_kriteria'),
                    'slug' => $slug,
                    'tipe_kriteria' => $this->request->getVar('tipe_kriteria'),
                    'bobot_kriteria' => $this->request->getVar('bobot_kriteria'),
                ];
                $this->M_Kriteria->save($save);
                $pesan = [
                    'sukses' => 'Berhasil ditambahkan'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    EDIT   --------------------------------------------------------------------  
    public function form_edit()
    {
        if ($this->request->isAJAX()) {
            $slug = $this->request->getVar('slug');
            $ik = $this->M_Kriteria->getKriteria($slug);
            $data = [
                'id_kriteria' => $ik['id_kriteria'],
                'slug' => $ik['slug'],
                'nama_kriteria' => $ik['nama_kriteria'],
                'tipe_kriteria' => $ik['tipe_kriteria'],
                'bobot_kriteria' => $ik['bobot_kriteria'],
            ];
            $pesan = [
                'sukses' => view('Input/Kriteria/modal_edit', $data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $krit_lama = $this->M_Kriteria->getKriteria($this->request->getVar('slug'));
            if ($krit_lama['nama_kriteria'] == $this->request->getVar('nama_kriteria')) {
                $rule = 'required';
            } else {
                $rule = 'required|is_unique[tbl_kriteria.nama_kriteria]';
            }
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kriteria' => [
                    'label' => 'Nama Kriteria',
                    'rules' => $rule,
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ],
                'tipe_kriteria' => [
                    'label' => 'Tipe Kriteria',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'bobot_kriteria' => [
                    'label' => 'Bobot Kriteria',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'numeric' => '{field} Harus Diisi dengan Angka!'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_kriteria' => $validation->getError('nama_kriteria'),
                        'tipe_kriteria' => $validation->getError('tipe_kriteria'),
                        'bobot_kriteria' => $validation->getError('bobot_kriteria'),
                    ]
                ];
            } else {
                $slug = url_title($this->request->getVar('nama_kriteria'), '-', true);
                $save = [
                    'nama_kriteria' => $this->request->getVar('nama_kriteria'),
                    'slug' => $slug,
                    'tipe_kriteria' => $this->request->getVar('tipe_kriteria'),
                    'bobot_kriteria' => $this->request->getVar('bobot_kriteria'),
                ];
                $id_kriteria = $this->request->getVar('id_kriteria');
                $this->M_Kriteria->update($id_kriteria, $save);
                $pesan = [
                    'sukses' => 'Berhasil diubah'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    DELETE   --------------------------------------------------------------------
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_kriteria = $this->request->getVar('id_kriteria');
            $cek = $this->M_Sub_Kriteria->getSub($id_kriteria);
            $this->M_Kriteria->delete($id_kriteria);
            $cek2  = $this->M_Kriteria->error();
            if ($cek2['code'] != 0) {
                $pesan = [
                    'error' => 'Gagal dihapus',
                ];
            } else {
                $pesan = [
                    'sukses' => 'Berhasil dihapus'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
}
