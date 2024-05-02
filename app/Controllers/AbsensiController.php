<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AbsensiController extends BaseController
{
    public $akunModel, $kehadiranModel, $keluarModel, $mahasiswaModel;
    public function __construct()
    {
        $this->akunModel = new \App\Models\AbsensiAkun();
        $this->kehadiranModel = new \App\Models\AbsensiKehadiran();
        $this->keluarModel = new \App\Models\AbsensiKeluar();
        $this->mahasiswaModel = new \App\Models\AbsensiMahasiswa();
    }
    public function loginAction()
    {
        session()->set('LOGGED_IN', false);
        $username = session()->getFlashdata('username');
        $password = strval(session()->getFlashdata('password'));

        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Nama pengguna dan kata sandi diperlukan');
            return redirect()->back();
        }

        $userCheck = null;
        $userCheck = $this->akunModel->where('username', $username)->first();

        if (!$userCheck) {
            session()->setFlashdata('error', 'Pengguna tidak ditemukan');
            return redirect()->back();
        }

        if (!password_verify($password, $userCheck['password'])) {
            session()->setFlashdata('error', 'Kata sandi salah');
            return redirect()->back();
        } else {
            session()->set('LOGGED_IN', true);
            if ($userCheck['role'] == 'mahasiswa') {
                $datamhs = $this->mahasiswaModel->join('akun', 'mahasiswa.idakun = akun.idakun', 'inner')
                    ->where('akun.idakun', $userCheck['idakun'])
                    ->first();
                session()->set('idmhs', $datamhs['idmhs']);
                session()->set('role', 'mahasiswa');
                session()->set('usernamee', $datamhs['namamhs']);
                return redirect()->to(base_url('absensi/form_kehadiran'));
            } elseif ($userCheck['role'] == 'admin') {
                session()->set('role', 'admin');
                return redirect()->to(base_url('absensi/dashboard'));
            } elseif ($userCheck['role'] == 'operator') {
                session()->set('role', 'operator');
                return redirect()->to(base_url('absensi/operator/dashboard'));
            }
        }
    }
    public function kehadiranAction()
    {
        $namamhs = $this->request->getPost('namamhs');
        $locationStatus = $this->request->getPost('locationStatus');
        if ($locationStatus == "false") {
            return redirect()->back()->withInput()->with('error', 'Lokasi tidak sesuai');
        }
        if (empty($namamhs)) {
            return redirect()->back()->withInput()->with('error', 'Nama mahasiswa diperlukan');
        }
        $mahasiswa = $this->mahasiswaModel->where('namamhs', $namamhs)->first();
        if (!$mahasiswa) {
            return redirect()->back()->withInput()->with('error', 'Mahasiswa tidak ditemukan');
        }
        $today = date('Y-m-d');
        $existingKehadiran = $this->kehadiranModel->where('idmhs', $mahasiswa['idmhs'])
            ->where('tanggal >=', $today)
            ->first();
        if ($existingKehadiran) {
            return redirect()->back()->withInput()->with('error', 'Mahasiswa sudah melakukan kehadiran hari ini');
        }
        $data = [
            'idmhs' => $mahasiswa['idmhs'],
            'tanggal' => date('Y-m-d H:i:s'),
            'keluar' => false
        ];
        $this->kehadiranModel->insert($data);

        return redirect()->back()->with('success', 'Kehadiran berhasil dicatat');
    }
    public function dashboardFilter($date)
    {
        $dataKehadiran = $this->kehadiranModel->where('DATE(tanggal)', $date)->join('mahasiswa', 'kehadiran.idmhs = mahasiswa.idmhs', 'inner')->findAll();
        $dataKeluar = $this->keluarModel->where('DATE(tanggal)', $date)->join('mahasiswa', 'keluar.idmhs = mahasiswa.idmhs', 'inner')->findAll();
        if (session('LOGGED_IN') == true) {
            return view('absensi/admin/dashboardFilter', [
                'dataHadir' => $dataKehadiran,
                'dataKeluar' => $dataKeluar
            ]);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function addAkunAction()
    {
        $role = $this->request->getPost('role');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $password = password_hash(strval($password), PASSWORD_BCRYPT);

        if (!in_array($role, ['mahasiswa', 'admin', 'operator'])) {
            return redirect()->back()->withInput()->with('error', 'Role tidak valid');
        }

        if ($role == 'mahasiswa') {
            $namamhs = $this->request->getPost('namamhs');

            if (empty($namamhs)) {
                return redirect()->back()->withInput()->with('error', 'Nama mahasiswa diperlukan');
            }
        }

        if (empty($username)) {
            return redirect()->back()->withInput()->with('error', 'Username diperlukan');
        }

        if (empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Password diperlukan');
        }

        $this->akunModel->insert([
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ]);

        if ($role == 'mahasiswa') {
            $id = $this->akunModel->insertID();
            $this->mahasiswaModel->insert([
                'idakun' => $id,
                'namamhs' => $namamhs
            ]);
        }

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan');
    }
    public function keluarAction()
    {
        $today = date('Y-m-d');
        $existingKeluar = $this->keluarModel->where('idmhs', session('idmhs'))
            ->where('tanggal >=', $today)
            ->first();
        if ($existingKeluar) {
            return redirect()->back()->withInput()->with('error', 'Mahasiswa sudah melakukan kehadiran hari ini');
        }
        $this->keluarModel->set([
            'idmhs' => session('idmhs'),
            'tanggal' => date('Y-m-d H:i:s')
        ])->insert();

        return redirect()->back();
    }
    public function tokenValidation($token)
    {
        if (empty($token)) {
            return redirect()->to(base_url());
        }
        $resultDB = $this->akunModel->where('token', $token)->first();
        if (!empty($resultDB)) {
            session()->set('LOGGED_IN', true);
            if ($resultDB['role'] == 'mahasiswa') {
                $datamhs = $this->mahasiswaModel->join('akun', 'mahasiswa.idakun = akun.idakun', 'inner')
                    ->where('akun.idakun', $resultDB['idakun'])
                    ->first();
                session()->set('username', $datamhs['namamhs']);
                session()->set('idmhs', $datamhs['idmhs']);
                session()->set('role', 'mahasiswa');
                return redirect()->to(base_url('form_kehadiran'));
            } elseif ($resultDB['role'] == 'admin') {
                session()->set('role', 'admin');
                return redirect()->to(base_url('dashboard'));
            } elseif ($resultDB['role'] == 'operator') {
                session()->set('role', 'operator');
                return redirect()->to(base_url('operator/dashboard'));
            }
        } else {
            return redirect()->to(base_url());
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
