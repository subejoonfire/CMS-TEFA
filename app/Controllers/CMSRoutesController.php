<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CMSRoutesController extends BaseController
{
    public function login()
    {
        if (session('LOGGED_IN', true)) {
            if (session('role') == 'admin') {
                return view('absensi/dashboard');
            } elseif (session('role') == 'mahasiswa') {
                return view('absensi/form_kehadiran');
            } elseif (session('role') == 'operator') {
                return view('absensi/operator/dashboard');
            } elseif (session('role') == 'AdminCMS') {
                return view('cms/dashboard');
            }
        }
        return view('login');
    }
    public function dashboard()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/dashboard');
        }
        return view('login');
    }
    public function contact()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/contact');
        }
        return view('login');
    }

    public function client()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/client');
        }
        return view('login');
    }

    public function photo()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/photo');
        }
        return view('login');
    }

    public function portfolio()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/portfolio');
        }
        return view('login');
    }

    public function service()
    {
        if (session('LOGGED_IN', true) && session('role', 'AdminCMS')) {
            return view('cms/service');
        }
        return view('login');
    }
    public function ClientApi()
    {
        $ModelClient = new \App\Models\Klien();
        $jsonResult = json_encode($ModelClient->findAll(), JSON_UNESCAPED_UNICODE);
        echo $jsonResult;
        exit;
    }

    public function PhotoApi()
    {
        $ModelPhoto = new \App\Models\Foto();
        $jsonResult = json_encode($ModelPhoto->findAll(), JSON_UNESCAPED_UNICODE);
        echo $jsonResult;
        exit;
    }

    public function PortfolioApi()
    {
        $ModelPortfolio = new \App\Models\Portofolio();
        $jsonResult = json_encode($ModelPortfolio->findAll(), JSON_UNESCAPED_UNICODE);
        echo $jsonResult;
        exit;
    }
    public function ServiceApi()
    {
        $ModelLayanan = new \App\Models\Layanan();
        $ModelLayanan = $ModelLayanan->findAll();
        $jsonData = json_encode($ModelLayanan, JSON_UNESCAPED_UNICODE);
        echo $jsonData;
        exit;
    }
}
