<?php

namespace App\Controllers;

use App\Models\M_Nilai;


class Nilai extends BaseController
{
    protected $M_Nilai;

    public function __construct()
    {
        $this->M_Nilai = new M_Nilai();
    }
    // ---------------------------------------------------    VIEW   --------------------------------------------------------------------
    public function index()
    {
        return view('Input/Nilai/v_nilai');
    }
    public function list_nilai()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nilai' => $this->M_Nilai->getNilai()
            ];
            $msg = [
                'data' => view('Input/Nilai/list_nilai', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
    // ---------------------------------------------------    ADD   --------------------------------------------------------------------
    public function form_add()
    {
        if ($this->request->isAJAX()) {
            $tampil = [
                'data' => view('Input/Nilai/modal_add')
            ];
            echo json_encode($tampil);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
    public function tambah()
    {
        if ($this->request->isAJAX()) {
            helper('form');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'ket_nilai' => [
                    'label' => 'Rentang Nilai',
                    'rules' => 'required|is_unique[tbl_nilai.ket_nilai]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ],
                'bobot_nilai' => [
                    'label' => 'Bobot Nilai',
                    'rules' => 'required|is_unique[tbl_nilai.jum_nilai]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'ket_nilai' => $validation->getError('ket_nilai'),
                        'bobot_nilai' => $validation->getError('bobot_nilai'),
                    ]
                ];
            } else {
                $save = [
                    'ket_nilai' => $this->request->getVar('ket_nilai'),
                    'jum_nilai' => $this->request->getVar('bobot_nilai'),
                ];
                $this->M_Nilai->save($save);
                $pesan = [
                    'sukses' => 'Berhasil ditambahkan'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
    // ---------------------------------------------------    EDIT   --------------------------------------------------------------------
    public function form_edit()
    {
        if ($this->request->isAJAX()) {
            $id_nilai = $this->request->getVar('id_nilai');
            $nilai = $this->M_Nilai->getNilai($id_nilai);
            $data = [
                'id_nilai' => $nilai['id_nilai'],
                'ket_nilai' => $nilai['ket_nilai'],
                'jum_nilai' => $nilai['jum_nilai'],
            ];
            $pesan = [
                'sukses' => view('Input/Nilai/modal_edit', $data)
            ];
            echo json_encode($pesan);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id_nilai = $this->request->getVar('id_nilai');
            $nilai_lama = $this->M_Nilai->getNilai($id_nilai);
            if ($nilai_lama['ket_nilai'] == $this->request->getVar('ket_nilai')) {
                $rule = 'required';
            } else {
                $rule = 'required|is_unique[tbl_nilai.ket_nilai]';
            }
            if ($nilai_lama['jum_nilai'] == $this->request->getVar('bobot_nilai')) {
                $rule_n = 'required';
            } else {
                $rule_n = 'required|is_unique[tbl_nilai.jum_nilai]';
            }
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'ket_nilai' => [
                    'label' => 'Rentang Nilai',
                    'rules' => $rule,
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ],
                'bobot_nilai' => [
                    'label' => 'Bobot Nilai',
                    'rules' => $rule_n,
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'ket_nilai' => $validation->getError('ket_nilai'),
                        'bobot_nilai' => $validation->getError('bobot_nilai'),
                    ]
                ];
            } else {
                $save = [
                    'ket_nilai' => $this->request->getVar('ket_nilai'),
                    'jum_nilai' => $this->request->getVar('bobot_nilai'),
                ];
                $id_nilai = $this->request->getVar('id_nilai');
                // var_dump($id_nilai, $save);
                $this->M_Nilai->update($id_nilai, $save);
                $pesan = [
                    'sukses' => 'Berhasil diubah'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
    // ---------------------------------------------------    DELETE   --------------------------------------------------------------------
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id_nilai = $this->request->getVar('id_nilai');
            $this->M_Nilai->delete($id_nilai);
            // \var_dump($id_nilai);
            $pesan = [
                'sukses' => 'Berhasil dihapus'
            ];
            echo json_encode($pesan);
        } else {
            exit('Maaf Data Tidak Dapat Diproses!');
        }
    }
}
