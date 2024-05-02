<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AbsensiRoutesController extends BaseController
{
    public $kehadiranModel, $keluarModel;
    
    public function __construct()
    {
        $this->kehadiranModel = new \App\Models\AbsensiKehadiran();
        $this->keluarModel = new \App\Models\AbsensiKeluar();
    }
    public function form_kehadiran()
    {
        if (session('LOGGED_IN') == true) {
            $kehadiranStatus = $this->kehadiranModel->where('idmhs', session('idmhs'))
                ->where('DATE(tanggal)', date('Y-m-d'))
                ->get()->getRow();
            $keluarStatus = $this->keluarModel->where('idmhs', session('idmhs'))
                ->where('DATE(tanggal)', date('Y-m-d'))
                ->get()->getRow();
            if (session('role') == 'mahasiswa') {
                if ($kehadiranStatus) {
                    session()->set('kehadiranStatus', true);
                } else {
                    session()->set('kehadiranStatus', false);
                }
                if ($keluarStatus) {
                    session()->set('keluarStatus', true);
                } else {
                    session()->set('keluarStatus', false);
                }
                return view('absensi/form_kehadiran');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function operatorDashboard()
    {
        if (session('LOGGED_IN') == true) {
            return view('absensi/operator/dashboard');
        }
        else {
            return redirect()->to(base_url('/'));
        }
    }
    public function dashboard()
    {
        if (session('LOGGED_IN') == true) {
            if (session('role') == 'admin') {
                return view('absensi/admin/dashboard');
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->to(base_url('login'));
        }
    }
}
