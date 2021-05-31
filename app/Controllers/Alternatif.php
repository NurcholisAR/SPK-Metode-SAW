<?php

namespace App\Controllers;

use App\Models\M_Alternatif;
use App\Models\MS_Alternatif;
use App\Models\M_Kriteria;
use App\Models\M_Penilaian;
use Config\Services;

class Alternatif extends BaseController
{
    protected $M_Alter;
    protected $MS_Alter;
    protected $M_Kriteria;
    protected $M_Penilaian;
    public function __construct()
    {
        $this->M_Alter = new M_Alternatif();
        $this->M_Kriteria = new M_Kriteria();
        $this->M_Penilaian = new M_Penilaian();
    }
    // ---------------------------------------------------    VIEW   --------------------------------------------------------------------
    public function index()
    {
        return view('Input/Alternatif/v_alternatif');
    }
    public function detail()
    {
        if ($this->request->isAJAX()) {
            $slug = $this->request->getVar('slug');
            $id_alternatif = $this->request->getVar('id_alternatif');
            $alter  = $this->M_Alter->getJoin($id_alternatif);
            $ia = $this->M_Penilaian->get_by_id($id_alternatif);
            $data = [];
            foreach ($alter->getResultArray() as $result) {
                $data = array(
                    'id_alternatif' =>   $result['id_alternatif'],
                    'nis_alternatif' => $result['nis_alternatif'],
                    'nama_alternatif' => $result['nama_alternatif'],
                    // 'id_kriteria' => $result['id_kriteria'],
                    'nama_kriteria' => $result['nama_kriteria'],
                    'nilai_penilaian' => $result['nilai_penilaian'],
                    'jk_alternatif' => $result['jk_alternatif'],
                    'agama_alternatif' => $result['agama_alternatif'],
                    'telp_alternatif' => $result['telp_alternatif'],
                    'alamat_alternatif' => $result['alamat_alternatif'],
                    'hasil_norm' => $result['hasil_norm'],
                    'kriteria' => $this->M_Kriteria->get_detail($id_alternatif),
                    'penilaian' => $this->M_Penilaian->getPenilaian(),
                    'kriteria1' => $this->M_Kriteria->getKriteria()
                );
            }
            $tampil = [
                'data' => view('Input/Alternatif/detail_alter', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_alter()
    {
        if ($this->request->isAjax()) {
            $data = [
                'alternatif' => $this->M_Alter->getAlternatif(),
            ];
            $tampil = [
                'data' => view('Input/Alternatif/list_alter', $data)
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function list_data()
    {
        $request = Services::request();
        $datamodel = new MS_Alternatif($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $detil = "<button type=\"button\" class=\"btn btn-sm btn-primary btn-flat\" onclick=\"detail('" . $list->id_alternatif . "')\"><i class=\"fa fa-info\"></i></button>";
                $edit = "<button type=\"button\" class=\"btn btn-sm btn-info btn-flat\" onclick=\"edit('" . $list->slug . "')\"><i class=\"fa fa-edit\"></i></button>";
                $delet = "<button type=\"button\" class=\"btn btn-sm btn-danger btn-flat\" onclick=\"hapus('" . $list->id_alternatif . "')\"><i class=\"fa fa-trash\"></i></button>";
                $row[] = $no;
                $row[] = $list->nis_alternatif;
                $row[] = $list->nama_alternatif;
                $row[] = $list->tahun;
                $row[] = $detil . " " . $edit . " " . $delet;
                $row[] = '';
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    // ---------------------------------------------------    UPLOAD   --------------------------------------------------------------------
    public function upload()
    {
        if ($this->request->isAJAX()) {
            $tampil = [
                'data' => view('Input/Alternatif/modal_up')
            ];
            echo json_encode($tampil);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function upload_file()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'file_upload'   => [
                    'label'     => 'Inputan File',
                    'rules'     => 'uploaded[file_upload]|ext_in[file_upload,xls,xlsx]',
                    'errors'    => [
                        'uploaded'  => '{field} Tidak Boleh Kosong!',
                        'ext_in'    => '{field} Harus Ekstensi xls atau xlsx'
                    ]
                ]
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'file_upload' => $validation->getError('file_upload')
                    ]
                ];
            } else {
                $file = $this->request->getFile('file_upload');
                $ext = $file->getClientExtension();
                if ($ext == 'xls') {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $excel = $render->load($file);
                $data = $excel->getActiveSheet()->toArray();

                $error = [];
                $jum_error = 0;
                $jum_sukses = 0;

                foreach ($data as $x => $row) {
                    if ($x == 0) {
                        continue;
                    }
                    $nis = $row[1];
                    $nama = $row[2];
                    $telp = $row[3];
                    $jk = $row[4];
                    $agama = $row[5];
                    $alamat = $row[6];
                    $ta = $row[7];

                    $db = \Config\Database::connect();

                    $cek_nis = $db->table('tbl_alternatif')->getWhere(['nis_alternatif' => $nis])->getResult();
                    if (count($cek_nis) > 0) {
                        $jum_error++;
                    } else {
                        $save = [
                            'nama_alternatif' => $nama,
                            'nis_alternatif' => $nis,
                            'slug' => url_title($nama, '-', true) . strtotime(date('Y-m-d H:i:s')),
                            'telp_alternatif' => $telp,
                            'jk_alternatif' => $jk,
                            'agama_alternatif' => $agama,
                            'alamat_alternatif' => $alamat,
                            'tahun' => $ta,
                        ];
                        // var_dump($save);
                        $db->table('tbl_alternatif')->insert($save);
                        $jum_sukses++;
                    }
                }

                $pesan = [
                    'sukses' => " $jum_sukses: Data Disimpan.  $jum_error: Data Gagal Disimpan Atau Sudah Ada . "
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    ADD   --------------------------------------------------------------------
    public function form_add_alter()
    {
        if ($this->request->isAJAX()) {
            $tampil = [
                'data' => view('Input/Alternatif/modal_add_alter')
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
                'nis_alternatif' => [
                    'label' => 'NIS',
                    'rules' => 'required|is_unique[tbl_alternatif.nis_alternatif]|min_length[5]',
                    'errors' => [
                        'required' => '{field} Alternatif harus diisi',
                        'is_unique' => '{field} Alternatif sudah ada',
                        'min_length' => '{field} minimal 5'
                    ]
                ],
                'nama_alternatif' => [
                    'label' => 'Nama Alternatif',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Alternatif harus diisi',
                    ]
                ],
                'telp_alternatif' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'No Telepon harus diisi',
                        'numeric' => 'Hanya diisi dengan angka'
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin harus diisi'
                    ]
                ],
                'agama_alternatif' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Agama harus diisi'
                    ]
                ],
                'alamat_alternatif' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi'
                    ]
                ],
                'tahun' => [
                    'label'            => 'Tahun Ajaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi'
                    ]
                ],
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nama_alternatif' =>  $validation->getError('nama_alternatif'),
                        'nis_alternatif' =>  $validation->getError('nis_alternatif'),
                        // 'kelas_alternatif' =>  $validation->getError('kelas_alternatif'),
                        // 'jurusan_alternatif' =>  $validation->getError('jurusan_alternatif'),
                        'telp_alternatif' =>  $validation->getError('telp_alternatif'),
                        'jenis_kelamin' =>  $validation->getError('jenis_kelamin'),
                        'agama_alternatif' =>  $validation->getError('agama_alternatif'),
                        'alamat_alternatif' =>  $validation->getError('alamat_alternatif'),
                        'tahun' =>  $validation->getError('tahun')
                    ]
                ];
            } else {
                $slug = url_title($this->request->getPost('nama_alternatif'), '-', true) .  strtotime(date('Y-m-d H:i:s'));
                $save = [
                    'nama_alternatif' => $this->request->getVar('nama_alternatif'),
                    'nis_alternatif' => $this->request->getVar('nis_alternatif'),
                    'slug' => $slug,
                    'telp_alternatif' => $this->request->getVar('telp_alternatif'),
                    'jk_alternatif' => $this->request->getVar('jenis_kelamin'),
                    'agama_alternatif' => $this->request->getVar('agama_alternatif'),
                    'alamat_alternatif' => $this->request->getVar('alamat_alternatif'),
                    'tahun' => $this->request->getVar('tahun')
                ];
                $this->M_Alter->save($save);
                // var_dump($save);
                $pesan = [
                    'sukses' => 'Berhasil ditambah'
                ];
            }
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    // ---------------------------------------------------    EDIT   --------------------------------------------------------------------
    public function form_edit1()
    {
        if ($this->request->isAJAX()) {
            $slug = $this->request->getVar('slug');
            $ea = $this->M_Alter->find($slug);
            $data = [
                'id_alternatif' => $ea['id_alternatif'],
                'slug' => $ea['slug'],
                'nis_alternatif' => $ea['nis_alternatif'],
                'nama_alternatif' => $ea['nama_alternatif'],
                'telp_alternatif' => $ea['telp_alternatif'],
                'jk_alternatif' => $ea['jk_alternatif'],
                'agama_alternatif' => $ea['agama_alternatif'],
                'alamat_alternatif' => $ea['alamat_alternatif'],
                'tahun_masuk' => $ea['tahun_masuk'],
            ];
            $pesan = [
                'sukses' => view('Input/Alternatif/modal_edit', $data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function form_edit()
    {
        if ($this->request->isAJAX()) {
            $slug = $this->request->getVar('slug');
            $ea = $this->M_Alter->getAlternatif($slug);
            $data = [
                'id_alternatif' => $ea['id_alternatif'],
                'slug' => $ea['slug'],
                'nis_alternatif' => $ea['nis_alternatif'],
                'nama_alternatif' => $ea['nama_alternatif'],
                // 'kelas_alternatif' => $ea['kelas_alternatif_id'],
                // 'jurusan_alternatif' => $ea['jurusan_alternatif_id'],
                'telp_alternatif' => $ea['telp_alternatif'],
                'jk_alternatif' => $ea['jk_alternatif'],
                'agama_alternatif' => $ea['agama_alternatif'],
                'alamat_alternatif' => $ea['alamat_alternatif'],
                'tahun' => $ea['tahun'],
            ];
            $pesan = [
                'sukses' => view('Input/Alternatif/modal_edit', $data)
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $nis_lama = $this->M_Alter->getAlternatif($this->request->getVar('slug'));
            if ($nis_lama['nis_alternatif'] == $this->request->getVar('nis_alternatif')) {
                $rule = 'required|min_length[5]';
            } else {
                $rule = 'required|is_unique[tbl_alternatif.nis_alternatif]|min_length[5]';
            }
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nis_alternatif' => [
                    'label' => 'NIS Alternatif',
                    'rules' => $rule,
                    'errors' => [
                        'required' => '{field} harus diisi',
                        'is_unique' => '{field} sudah ada',
                        'min_length' => '{field} minimal 5'
                    ]
                ],
                'nama_alternatif' => [
                    'label' => 'nama_alternatif',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama Alternatif harus diisi',
                    ]
                ],
                'telp_alternatif' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'No Telepon harus diisi',
                        'numeric' => 'Hanya diisi dengan angka'
                    ]
                ],
                'jenis_kelamin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin harus diisi'
                    ]
                ],
                'agama_alternatif' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Agama harus diisi'
                    ]
                ],
                'alamat_alternatif' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi'
                    ]
                ],
                'tahun' => [
                    'label' => 'Tahun',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus diisi'
                    ]
                ],
            ]);
            if (!$valid) {
                $pesan = [
                    'error' => [
                        'nis_alternatif' =>  $validation->getError('nis_alternatif'),
                        'nama_alternatif' =>  $validation->getError('nama_alternatif'),
                        // 'kelas_alternatif' =>  $validation->getError('kelas_alternatif'),
                        // 'jurusan_alternatif' =>  $validation->getError('jurusan_alternatif'),
                        'telp_alternatif' =>  $validation->getError('telp_alternatif'),
                        'jenis_kelamin' =>  $validation->getError('jenis_kelamin'),
                        'agama_alternatif' =>  $validation->getError('agama_alternatif'),
                        'alamat_alternatif' =>  $validation->getError('alamat_alternatif'),
                        'tahun' =>  $validation->getError('tahun')
                    ]
                ];
            } else {

                $slug1 = url_title($this->request->getPost('nama_alternatif'), '-', true) .  -strtotime(date('Y-m-d H:i:s'));
                $save = [
                    'nis_alternatif' => $this->request->getVar('nis_alternatif'),
                    'nama_alternatif' => $this->request->getVar('nama_alternatif'),
                    'slug' => $slug1,
                    // 'kelas_alternatif_id' => $this->request->getVar('kelas_alternatif'),
                    // 'jurusan_alternatif_id' => $this->request->getVar('jurusan_alternatif'),
                    'telp_alternatif' => $this->request->getVar('telp_alternatif'),
                    'jk_alternatif' => $this->request->getVar('jenis_kelamin'),
                    'agama_alternatif' => $this->request->getVar('agama_alternatif'),
                    'alamat_alternatif' => $this->request->getVar('alamat_alternatif'),
                    'tahun' => $this->request->getVar('tahun')
                ];
                $id_alternatif = $this->request->getVar('id_alternatif');

                $this->M_Alter->update($id_alternatif, $save);
                // var_dump($id_alternatif, $save);
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
            $id_alternatif = $this->request->getVar('id_alternatif');
            $this->M_Alter->delete($id_alternatif);
            $pesan = [
                'sukses' => 'Berhasil dihapus'
            ];
            echo json_encode($pesan);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
}
