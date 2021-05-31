<?php

namespace App\Controllers;

use App\Models\M_Alternatif;
use App\Models\M_Kriteria;
use App\Models\M_Penilaian;

class Home extends BaseController
{
	protected $M_Alter;
	protected $M_Kriteria;
	protected $M_Penilaian;

	public function __construct()
	{
		$this->M_Alter = new M_Alternatif();
		$this->M_Kriteria = new M_Kriteria();
		$this->M_Penilaian = new M_Penilaian();
	}

	public function index()
	{
		$data = [
			'title' => 'Beranda',
		];
		return view('Admin/beranda', $data);
	}

	//--------------------------------------------------------------------
	public function list_kartu()
	{
		if ($this->request->isAJAX()) {
			$a = $this->request->getVar('tahun_masuk');
			if ($a) {
				$fil = $this->M_Alter->jum_alter_f($a);
				$bel = $this->M_Alter->belum_dinilai_f($a);
				$sud = $this->M_Alter->sudah_dinilai_f($a);
				$c1 = $this->M_Alter->chart_1fa($a);
				$c2 = $this->M_Alter->chart_1fb($a);
			} else {
				$fil = $this->M_Alter->jum_alter();
				$bel = $this->M_Alter->belum_dinilai();
				$sud = $this->M_Alter->sudah_dinilai();
				$c1 = $this->M_Alter->chart1a();
				$c2 = $this->M_Alter->chart1b();
			}
			$data = [
				'alternatif' => $fil,
				'belum' => $bel,
				'sudah' => $sud,
				'c1' => $c1,
				'c2' => $c2,
			];
			$tampil = [
				'alter' => view('Admin/Beranda/list_alter', $data),
				'belum' => view('Admin/Beranda/list_belum', $data),
				'sudah' => view('Admin/Beranda/list_sudah', $data),
				'chart1' => view('Admin/Beranda/chart1', $data),
			];
			echo json_encode($tampil);
		} else {
			exit('maaf data tidak dapat diproses!');
		}
	}
}
