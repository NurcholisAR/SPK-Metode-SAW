<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        // echo password_hash('admin', PASSWORD_BCRYPT);
        return view('Admin/Login/v_login');
    }
    public function cekuser()
    {
        if ($this->request->isAJAX()) {
            $user = $this->request->getVar('username');
            $pass = $this->request->getVar('password');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Nama Pengguna',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ],
                'password' => [
                    'label' => 'Kata Sandi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong!'
                    ]
                ]
            ]);
            if (!$valid) {
                $psn = [
                    'error' => [
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password')
                    ]
                ];
            } else {
                // cek user di db
                $cek_user = $this->db->query("select * from tbl_login where username = '$user'");
                $result = $cek_user->getResult();
                if (count($result) > 0) {
                    $row = $cek_user->getRow();
                    $password_user = $row->password;

                    if (password_verify($pass, $password_user)) {
                        // session
                        $simpan_session = [
                            'Login' => true,
                            'username' => $user,
                            'nama_user' => $row->nama_user
                        ];
                        $this->session->set($simpan_session);
                        $psn = [
                            'sukses' => [
                                'link' => '/Home'
                            ]
                        ];
                    } else {
                        $psn = [
                            'error' => [
                                'password' => 'Kata Sandi anda Salah',
                            ]
                        ];
                    }
                } else {
                    $psn = [
                        'error' => [
                            'username' => 'username tidak ditemukan',
                            // 'password' => $validation->getError('password')
                        ]
                    ];
                }
            }

            echo json_encode($psn);
        } else {
            exit('maaf data tidak dapat diproses!');
        }
    }
    public function keluar()
    {
        $this->session->destroy();
        return redirect()->to('/Login');
    }
}
