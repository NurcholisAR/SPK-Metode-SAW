<?php

namespace App\Controllers;

use App\Models\M_Alternatif;
use App\Models\M_Kelas;
use App\Models\M_Kriteria;
use App\Models\M_Sub_Kriteria;
use App\Models\M_Penilaian;
use TCPDF;

class LaporanSAW extends BaseController
{
    protected $M_Alternatif;
    protected $M_Kriteria;
    protected $M_Sub_Kriteria;
    protected $M_Penilaian;
    protected $M_Kelas;
    public function __construct()
    {
        $this->M_Alternatif = new M_Alternatif();
        $this->M_Kriteria = new M_Kriteria();
        $this->M_Sub_Kriteria = new M_Sub_Kriteria();
        $this->M_Penilaian = new M_Penilaian();
    }
    // -------------------------------------------------------------------------------------------------------------------------    
    public function index()
    {
        return view('Input/LaporanSAW/v_laporan1');
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
            $data = [
                'kriteria_count' => $this->M_Kriteria->getKriteria_count(),
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'penilaian' => $filter,
                'alternatif' => $filter
                // 'alternatif' => $this->M_Peringkat->list_peringkat()
                // 'peringkat' => $this->M_Peringkat->list_peringkat()
            ];
            $tampil = [
                'data' => view('Input/LaporanSAW/list_data', $data)
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
                'kriteria_count' => $this->M_Kriteria->getKriteria_count(),
                'kriteria' => $this->M_Kriteria->getKriteria(),

            ];
            $tampil = [
                'data' => view('Input/LaporanSAW/list_kriteria', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_nilaiA()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kriteria_count' => $this->M_Kriteria->getKriteria_count(),
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'penilaian' => $this->M_Penilaian->list_penilaian()
            ];
            $tampil = [
                'sukses' => view('Input/LaporanSAW/list_nilai', $data),
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_normalisasi()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'kriteria_count' => $this->M_Kriteria->getKriteria_count(),
                'kriteria' => $this->M_Kriteria->getKriteria(),
                'penilaian' => $this->M_Penilaian->list_penilaian()
            ];
            $tampil = [
                'sukses' => view('Input/LaporanSAW/list_normalisasi', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_penilaian()
    {
        if ($this->request->isAJAX()) {
            $data = [];
            $tampil = [];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // -------------------------------------------------------------------------------------------------------------------------    

}
