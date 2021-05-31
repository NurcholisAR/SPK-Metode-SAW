<?php

namespace App\Controllers;

use App\Models\M_Alternatif;
use App\Models\M_Kriteria;
use App\Models\M_Penilaian;
use App\Models\M_Nilai;
use Config\Services;

class Penilaian extends BaseController
{

    protected $M_Alternatif;
    protected $M_Kriteria;
    protected $M_Sub_Kriteria;
    protected $M_Penilaian;
    protected $M_Nilai;
    public function __construct()
    {
        $this->M_Penilaian = new M_Penilaian();
        $this->M_Alternatif = new M_Alternatif();
        $this->M_Kriteria = new M_Kriteria();
        $this->M_Nilai = new M_Nilai();
    }
    // ---------------------------------------------------    VIEW   --------------------------------------------------------------------
    public function index()
    {
        return view('Input/Penilaian/v_penilaian');
    }
    public function normalisasi()
    {
        if ($this->request->isAJAX()) {
            $join_data = $this->M_Penilaian->getJoinData();
            foreach ($join_data as $jj) {
                $a = $jj['id_alternatif'];
                $c = $jj['tahun'];
                $norm = $this->M_Penilaian->nilaiR($a);
                foreach ($norm as $n) {
                    $b = $n['id_kriteria'];
                    $tipe = $n['tipe_kriteria'];
                    $bobot = $n['bobot_kriteria'];
                    $nilai_per = $n['nilai_penilaian'];
                    if ($tipe == "benefit") {
                        // $nilai_max = $this->M_Penilaian->nilai_max($b);
                        $nilai_max = $this->M_Penilaian->nilai_max($b, $c);
                        foreach ($nilai_max as $max) {
                            $nor = round($nilai_per / $max['mnr1'], 3);
                        }
                    } else {
                        // $nilai_min = $this->M_Penilaian->nilai_min($b);
                        $nilai_min = $this->M_Penilaian->nilai_min($b, $c);
                        foreach ($nilai_min as $min) {
                            $nor = round($min['mnr2'] / $nilai_per, 3);
                        }
                    }
                    $ia = $a;
                    $ik = $b;
                    $nn2 = $nor;
                    $nn3 = $bobot * $nor;
                    // $tes = array($ia, $ik, $nn2, $nn3, $nn4);
                    // var_dump($tes);
                    $this->M_Penilaian->normalisasi($ia, $ik, $nn2, $nn3);

                    $nilai = $this->M_Penilaian->hasil_norm($a);
                    foreach ($nilai as $n) {
                        $hasil = round($n['bbn'], 3);
                    }

                    $ia = $a;
                    $has = $hasil;
                    $this->M_Penilaian->simpan_hasil($ia, $has);
                    // $cek = array($ia, $has_ipa, $hasil_ips);
                    // var_dump($cek);
                }
            }
            $pesan = [
                'sukses' => 'Semua Data Berhasil dinormalisasi'
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function cek_norm()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'check_null' => $this->M_Penilaian->check_norm(),
                'check_ada' => $this->M_Penilaian->check_norm1()
            ];
            $tampil = [
                'data' => view('Input/Penilaian/cek_norm', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_Penilaian()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'list_penilaian' => $this->M_Penilaian->list_penilaian()
            ];
            $tampil = [
                'data' => view('Input/Penilaian/list_Penilaian', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    ADD   --------------------------------------------------------------------
    public function filter()
    {
        $filter_alter = $this->request->getVar('tahun_masuk');
        $data = $this->M_Alternatif->filter($filter_alter);
        echo json_encode($data);
    }
    public function form_add()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'alternatif' => $this->M_Alternatif->list_join(),
                // 'cek_alternatif' => $filter,
                'penilaian' => $this->M_Penilaian->getJoinData(),
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'Nilai' => $this->M_Nilai->get_nilai(),
                'count' => $this->M_Kriteria->getKriteria_count(),
            ];
            $tampil = [
                'data' => view('Input/Penilaian/modal_add', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function tambah()
    {
        if ($this->request->isAJAX()) {
            $id_alternatif = $this->request->getVar('nama_alternatif');
            $id_kriteria =   $this->request->getVar('kriteria');
            // $sub = $this->request->getVar('kriteria');
            $valdation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_alternatif' => [
                    'label' => 'Nama Alternatif',
                    'rules' => 'required|is_unique[tbl_penilaian.id_alternatif]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!',
                        'is_unique' => '{field} Sudah Ada'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_alternatif' => $valdation->getError('nama_alternatif'),
                    ]
                ];
            } else {
                // $this->M_Penilaian->create($id_alternatif, $id_kriteria, $sub);
                $this->M_Penilaian->create($id_alternatif, $id_kriteria);
                // $a = array($id_alternatif, $id_kriteria);
                $pesan = [
                    // 'sukses' => print_r($a)
                    'sukses' => 'Data Sukses Disimpan'
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
            $id_alternatif = $this->request->getVar('id_alternatif');
            $id_kriteria = $this->request->getVar('id_kriteria');
            $ia = $this->M_Penilaian->get_by_id($id_alternatif);
            $data = [];
            foreach ($ia->getResult() as $result) {
                $data = array(
                    'id_penilaian' => $result->id_penilaian,
                    'id_alternatif' =>   $result->id_alternatif,
                    'nis_alternatif' => $result->nis_alternatif,
                    'nama_alternatif' => $result->nama_alternatif,
                    'id_kriteria' => $result->id_kriteria,
                    'nama_kriteria' => $result->nama_kriteria,
                    'nilai_penilaian' => $result->nilai_penilaian,
                    'kriteria' => $this->M_Kriteria->getKriteria(),
                    'Nilai' => $this->M_Nilai->get_nilai(),
                    'penilaian' => $this->M_Penilaian->getPenilaian(),
                );
            }
            $pesan = [
                'sukses' => view('Input/Penilaian/modal_edit', $data)
                // 'sukses' => var_dump($data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $id_penilaian = $this->request->getVar('id_penilaian');
            $id_alternatif = $this->request->getVar('nama_alternatif');
            $id_kriteria = $this->request->getVar('kriteria');
            $this->M_Penilaian->edit($id_penilaian, $id_alternatif, $id_kriteria);
            $pesan = [
                'sukses' => 'Berhasil Diubah'
                // 'sukses' => var_dump($data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    DELETE   --------------------------------------------------------------------
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_alternatif = $this->request->getVar('id_alternatif');
            // $id_kriteria = $this->request->getVar('id_kriteria');
            // $this->M_Penilaian->delete($id_alternatif);
            $this->M_Penilaian->hapus($id_alternatif);
            $pesan = [
                // 'sukses' => var_dump($id_alternatif)
                'sukses' => 'Berhasil dihapus'
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
}
