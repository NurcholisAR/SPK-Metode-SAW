<?php

namespace App\Controllers;

use App\Models\M_Alternatif;
use App\Models\M_Kriteria;
use App\Models\M_Sub_Kriteria;
use App\Models\M_Penilaian;
use App\Models\M_jurusan;
use TCPDF;

class LaporanHAS extends BaseController
{
    protected $M_Alternatif;
    protected $M_Kriteria;
    protected $M_Sub_Kriteria;
    protected $M_Penilaian;
    protected $M_jurusan;
    public function __construct()
    {
        $this->M_Alternatif = new M_Alternatif();
        $this->M_Kriteria = new M_Kriteria();
        $this->M_Sub_Kriteria = new M_Sub_Kriteria();
        $this->M_Penilaian = new M_Penilaian();
        $this->M_jurusan = new M_jurusan();
    }
    // -------------------------------------------------------------------------------------------------------------------------    
    public function index()
    {
        return view('Input/LaporanHAS/v_laporan');
    }
    // -------------------------------------------------------------------------------------------------------------------------    
    public function list()
    {
        if ($this->request->isAJAX()) {
            $tahun = $this->request->getVar('tahun_masuk');
            if ($tahun) {
                $filter = $this->M_Penilaian->filter_tahun($tahun);
            } else {
                $filter = $this->M_Penilaian->list_penilaian();
            }
            if ($tahun) {
                $s_min = $this->M_Alternatif->skor_minF($tahun);
                $s_max = $this->M_Alternatif->skor_maxF($tahun);
                $s_jur = $this->M_jurusan->jurusan_f($tahun);
            } else {
                $s_min = $this->M_Alternatif->skor_min();
                $s_max = $this->M_Alternatif->skor_max();
                $s_jur = $this->M_jurusan->getJurusan();
            }
            $data = [
                'kriteria_count' => $this->M_Kriteria->getKriteria_count(),
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'penilaian' => $filter,
                'alternatif' => $filter,
                'min' => $s_min,
                'max' => $s_max,

            ];
            $tampil = [
                'data' => view('Input/LaporanHAS/list_data', $data),
                'min' => view('Input/LaporanHAS/min', $data),
                'max' => view('Input/LaporanHAS/max', $data),
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function cek_skor()
    {
        if ($this->request->isAJAX()) {
            $tahun = $this->request->getVar('tahun_masuk');
            $id_cek = $this->request->getVar('id_skor');
            $cek = $this->request->getVar('skor');
            $save = [
                // 'id_jurusan' => $id_cek,
                'skor_jurusan' => $cek,
            ];
            // var_dump($save);
            $this->M_jurusan->update($id_cek, $save);
            $pesan = [
                'sukses' => 'Berhasil diubah'
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
}
