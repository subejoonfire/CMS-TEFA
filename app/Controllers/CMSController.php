<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Validation\Validator;

class CMSController extends BaseController
{
    public $AkunModel, $FotoModel, $KlienModel, $KontakModel, $LayananModel, $PortofolioModel;
    function __construct()
    {
        $this->AkunModel = new \App\Models\Akun();
        $this->FotoModel = new \App\Models\Foto();
        $this->KlienModel = new \App\Models\Klien();
        $this->KontakModel = new \App\Models\Kontak();
        $this->LayananModel = new \App\Models\Layanan();
        $this->PortofolioModel = new \App\Models\Portofolio();
    }
    public function loginAction()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $resultDB = $this->AkunModel->where('username', $username)->first();
        if (empty($username) || empty($password)) {
            return redirect()->back();
        }
        if (!empty($resultDB)) {
            if (password_verify(strval($password), $resultDB['password'])) {
                if ($resultDB['role'] == 'mahasiswa' || $resultDB['role'] == 'admin' || $resultDB['role'] == 'operator') {
                    session()->setFlashdata([
                        'username' => $username,
                        'password' => $password,
                    ]);
                    return redirect()->to(base_url('absensi/loginAction'));
                } else {
                    session()->set('role', 'AdminCMS');
                    session()->set('LOGGED_IN', true);
                    return redirect()->to(base_url('cms/dashboard'));
                }
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function contactDelete($idkontak)
    {
        $result = $this->KontakModel->where('idkontak', $idkontak)->delete();
        if ($result) {
            return redirect()->back()->with('success', 'Pesan berhasil dihapus');
        }else{
            return redirect()->back()->with('error', 'Pesan gagal dihapus');
        }
    }

    public function contactCreate()
    {
        $nama = $this->request->getPost('nama');
        $subjek = $this->request->getPost('subjek');
        $telepon = $this->request->getPost('telepon');
        $pesan = $this->request->getPost('pesan');

        if (empty($nama)) {
            return redirect()->back()->with('error', 'Nama tidak boleh kosong');
        }

        if (strlen(strval($nama)) > 255) {
            return redirect()->back()->with('error', 'Nama terlalu panjang (maks. 255 karakter)');
        }

        if (preg_match('/[^\p{L}\p{N}\s]/', strval($nama))) {
            return redirect()->back()->with('error', 'Nama hanya boleh mengandung huruf, angka, dan spasi');
        }

        if (empty($subjek)) {
            return redirect()->back()->with('error', 'Subjek tidak boleh kosong');
        }

        if (strlen(strval($subjek)) > 255) {
            return redirect()->back()->with('error', 'Subjek terlalu panjang (maks. 255 karakter)');
        }

        if (empty($telepon)) {
            return redirect()->back()->with('error', 'Telepon tidak boleh kosong');
        }

        if (!preg_match('/^[0-9\+\-\s]+$/', strval($telepon))) {
            return redirect()->back()->with('error', 'Format telepon tidak valid');
        }

        $data = [
            'nama' => $nama,
            'subjek' => $subjek,
            'telpon' => $telepon,
            'pesan' => $pesan,
        ];

        $this->KontakModel->save($data);

        return redirect()->to('http://localhost:8081');
    }
    public function clientCreate()
    {
        $namaklien = $this->request->getPost('namaklien');
        $logo = $this->request->getFile('logoklien');

        if (empty($namaklien)) {
            return redirect()->back()->with('error', 'Nama klien tidak boleh kosong');
        } elseif (strlen(strval($namaklien)) > 255) {
            return redirect()->back()->with('error', 'Nama klien terlalu panjang (maks. 255 karakter)');
        } elseif (!preg_match('/^[a-zA-Z0-9_\s]+$/', strval($namaklien))) {
            return redirect()->back()->with('error', 'Nama klien hanya boleh mengandung huruf, angka, garis bawah, dan spasi');
        } elseif (!$logo) {
            return redirect()->back()->with('error', 'Logo tidak boleh kosong');
        } elseif ($logo->getError() !== UPLOAD_ERR_OK) {
            return redirect()->back()->with('error', 'Gagal mengunggah logo');
        }

        if ($logo->getError() === UPLOAD_ERR_OK) {
            $fileName = $logo->getRandomName();
            $ext = $logo->getExtension();
            if ($ext !== 'png') {
                return redirect()->back()->with('error', 'Format logo tidak valid. Hanya PNG yang diizinkan');
            }
            $logo->move(ROOTPATH . 'public/img/klien', $fileName);
        } else {
            return redirect()->back()->with('error', 'Gagal mengunggah logo');
        }

        $data = [
            'namaklien' => $namaklien,
            'logoklien' => $fileName,
        ];

        $this->KlienModel->save($data);
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function clientEdit(int $id)
    {
        if (!is_int($id) || $id <= 0) {
            return redirect()->to('/cms/client')->with('error', 'ID klien tidak valid');
        }

        $client = $this->KlienModel->find($id);
        if (!$client) {
            return redirect()->to('/cms/client')->with('error', 'Klien tidak ditemukan');
        }

        $namaklien = $this->request->getPost('namaklien');
        $logo = $this->request->getFile('logoklien');

        if (empty($namaklien)) {
            return redirect()->to('/cms/client/edit/' . $id)->with('error', 'Nama klien tidak boleh kosong');
        }

        $updateData = [
            'idklien' => $client['idklien'],
            'namaklien' => $namaklien,
        ];

        if ($logo->getError() === UPLOAD_ERR_OK) {
            $fileName = $logo->getRandomName();
            $ext = $logo->getExtension();
            if ($ext !== 'png') {
                return redirect()->to('/cms/client/edit/' . $id)->with('error', 'Format logo tidak valid. Hanya PNG yang diizinkan');
            }

            $logoPath = ROOTPATH . 'public/img/klien/' . $client['logoklien'];
            if (file_exists($logoPath) && is_writable($logoPath)) {
                unlink($logoPath);
            } else {
                return redirect()->to('/cms/client/edit/' . $id)->with('error', 'Gagal menghapus logo lama. Periksa izin akses file');
            }

            $logo->move(ROOTPATH . 'public/img/klien', $fileName);
            $updateData['logoklien'] = $fileName;
        }

        $this->KlienModel->set($updateData)->where('idklien', $client['idklien'])->update();

        return redirect()->to('/cms/client')->with('success', 'Klien berhasil diperbarui');
    }
    public function clientDetail(int $id)
    {
        $client = $this->KlienModel->find($id);
        session()->setFlashdata([
            'detail' => TRUE,
            'type' => 'client',
            'idklien' => $client['idklien'],
            'namaklien' => $client['namaklien'],
            'logoklien' => $client['logoklien']
        ]);
        return redirect()->back();
    }
    public function clientDelete(int $id)
    {
        if (!is_int($id) || $id <= 0) {
            return redirect()->to('/cms/client')->with('error', 'ID klien tidak valid');
        }

        $client = $this->KlienModel->find($id);
        if (!$client) {
            return redirect()->to('/cms/client')->with('error', 'Klien tidak ditemukan');
        }

        $logoPath = ROOTPATH . 'public/img/klien/' . $client['logoklien'];
        if (file_exists($logoPath) && is_writable($logoPath)) {
            unlink($logoPath);
        }

        $this->KlienModel->delete($id);

        return redirect()->to('/cms/client')->with('success', 'Klien berhasil dihapus');
    }
    public function photoCreate()
    {
        $idportfolio = $this->request->getPost('idportfolio');

        if (!is_numeric($idportfolio)) {
            return redirect()->to('/cms/photo')->with('error', 'ID Portofolio harus berupa bilangan bulat.');
        }

        $logo = $this->request->getFile('logo');

        if (!$logo) {
            return redirect()->to('/cms/photo')->with('error', 'Tidak ada file yang dipilih.');
        }

        if ($logo->getSize() > 1048576) {
            return redirect()->to('/cms/photo')->with('error', 'Ukuran file melebihi batas (1 MB).');
        }

        $allowedExtension = 'png';
        $clientExtension = strtolower($logo->getClientExtension());
        if ($clientExtension !== $allowedExtension) {
            return redirect()->to('/cms/photo')->with('error', 'Jenis file tidak diizinkan. Hanya PNG yang diperbolehkan.');
        }

        $fileName = $logo->getRandomName();

        $logo->move(ROOTPATH . 'public/img/konten', $fileName);

        try {
            $this->FotoModel->insert([
                'idportofolio' => $idportfolio,
                'foto' => $fileName,
            ]);
        } catch (\Exception $e) {
            return redirect()->to('/cms/photo')->with('error', 'Gagal menyimpan foto: ');
        }

        return redirect()->to('/cms/photo')->with('success', 'Foto berhasil disimpan');
    }

    public function photoDetail(int $id)
    {
        $client = $this->FotoModel->find($id);
        session()->setFlashdata([
            'detail' => TRUE,
            'type' => 'photo',
            'idfoto' => $client['idfoto'],
            'idportofolio' => $client['idportofolio'],
            'foto' => $client['foto'],
        ]);
        return redirect()->back();
    }
    public function photodetailDelete($idfoto)
    {
        $result = $this->FotoModel->where('idfoto', $idfoto)->delete();
        if ($result) {
            return redirect()->to('/cms/photo')->with('success', 'Foto berhasil dihapus');
        } else {
            return redirect()->to('/cms/photo')->with('error', 'Foto gagal dihapus');
        }
    }
    public function portfolioCreate()
    {
        $namaWebsite = $this->request->getPost('namawebsite');
        $foto = $this->request->getFile('foto');
        $deskripsiWebsite = $this->request->getPost('deskripsiwebsite');
        $linkWebsite = $this->request->getPost('linkwebsite');

        if (empty($namaWebsite)) {
            return redirect()->to('/cms/portfolio')->with('error', 'Nama website wajib diisi.');
        }

        if (empty($deskripsiWebsite)) {
            return redirect()->to('/cms/portfolio')->with('error', 'Deskripsi website wajib diisi.');
        }

        if (empty($linkWebsite) || !filter_var($linkWebsite, FILTER_VALIDATE_URL)) {
            return redirect()->to('/cms/portfolio')->with('error', 'Link website tidak valid.');
        }

        if ($foto->isValid() && !$foto->getError()) {
            $fileName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/img/portofolio', $fileName);
        } else {
            $fileName = null;
        }
        $res = $this->PortofolioModel->insert([
            'namawebsite' => $namaWebsite,
            'foto' => $fileName,
            'deskripsiwebsite' => $deskripsiWebsite,
            'linkwebsite' => $linkWebsite,
            'tanggal' => date('Y-m-d H:i:s'),
        ]);
        if ($res) {
            return redirect()->to('/cms/portfolio')->with('success', 'Item portofolio berhasil ditambahkan!');
        } else {
            return redirect()->to('/cms/portfolio')->with('error', 'Terjadi kesalahan saat membuat item portofolio.');
        }
    }
    public function portfolioDetail($idportofolio)
    {
        $client = $this->PortofolioModel->find($idportofolio);
        session()->setFlashdata([
            'detail' => TRUE,
            'type' => 'portfolio',
            'idportofolio' => $client['idportofolio'],
            'namawebsite' => $client['namawebsite'],
            'foto' => $client['foto'],
            'deskripsiwebsite' => $client['deskripsiwebsite'],
            'linkwebsite' => $client['linkwebsite'],
            'tanggal' => $client['tanggal'],
        ]);
        return redirect()->back();
    }
    public function portfolioEdit($id)
    {
        $portfolioData = $this->PortofolioModel->find($id);

        if (!$portfolioData) {
            return redirect()->to('/cms/portfolio')->with('error', 'Data portfolio tidak ditemukan.');
        }

        $namaWebsite = $this->request->getPost('namawebsite');
        $foto = $this->request->getFile('foto');
        $deskripsiWebsite = $this->request->getPost('deskripsiwebsite');
        $linkWebsite = $this->request->getPost('linkwebsite');

        if (empty($namaWebsite)) {
            return redirect()->to('/cms/portfolio/')->with('error', 'Nama website wajib diisi.');
        }

        if (empty($deskripsiWebsite)) {
            return redirect()->to('/cms/portfolio/')->with('error', 'Deskripsi website wajib diisi.');
        }

        if (empty($linkWebsite) || !filter_var($linkWebsite, FILTER_VALIDATE_URL)) {
            return redirect()->to('/cms/portfolio/')->with('error', 'Link website tidak valid.');
        }

        if ($foto->isValid() && !$foto->getError()) {
            $fileName = $foto->getRandomName();
            if ($portfolioData['foto'] && file_exists(ROOTPATH . 'public/img/portofolio/' . $portfolioData['foto'])) {
                unlink(ROOTPATH . 'public/img/portofolio/' . $portfolioData['foto']);
            }
            $foto->move(ROOTPATH . 'public/img/portofolio', $fileName);
        } else {
            $fileName = $portfolioData['foto'];
        }

        $res = $this->PortofolioModel->update($id, [
            'namawebsite' => $namaWebsite,
            'foto' => $fileName,
            'deskripsiwebsite' => $deskripsiWebsite,
            'linkwebsite' => $linkWebsite,
        ]);

        if ($res) {
            return redirect()->to('/cms/portfolio')->with('success', 'Item portofolio berhasil diperbarui!');
        } else {
            return redirect()->to('/cms/portfolio-edit')->with('error', 'Terjadi kesalahan saat memperbarui item portofolio.');
        }
    }
    public function portfolioDelete($idportfolio)
    {
        $result = $this->PortofolioModel->where('idportofolio', $idportfolio)->delete();

        if ($result) {
            return redirect()->to('/cms/portfolio')->with('success', 'Item portofolio berhasil dihapus!');
        } else {
            return redirect()->to('/cms/portfolio')->with('error', 'Terjadi kesalahan saat menghapus item portofolio.');
        }
    }
    public function serviceCreate()
    {
        $namaLayanan = $this->request->getPost('namalayanan');
        $deskripsiLayanan = $this->request->getPost('deskripsilayanan');

        if (empty($namaLayanan)) {
            return redirect()->to('/cms/service')->with('error', 'Nama layanan tidak boleh kosong');
        }

        if (strlen(strval($namaLayanan)) > 1024) {
            return redirect()->to('/cms/service')->with('error', 'Nama layanan tidak boleh lebih dari 1024 karakter');
        }

        if (empty($deskripsiLayanan)) {
            return redirect()->to('/cms/service')->with('error', 'Deskripsi layanan tidak boleh kosong');
        }

        $data = [
            'namalayanan' => $namaLayanan,
            'deskripsilayanan' => $deskripsiLayanan,
        ];

        $this->LayananModel->insert($data);

        return redirect()->to('/cms/service')->with('success', 'Item layanan berhasil dibuat!');
    }
    public function serviceDetail($idlayanan)
    {
        $client = $this->LayananModel->find($idlayanan);
        session()->setFlashdata([
            'detail' => TRUE,
            'type' => 'service',
            'idlayanan' => $client['idlayanan'],
            'namalayanan' => $client['namalayanan'],
            'deskripsilayanan' => $client['deskripsilayanan'],
        ]);
        return redirect()->back();
    }
    public function serviceEdit($idlayanan)
    {
        $namaLayanan = $this->request->getPost('namalayanan');
        $deskripsiLayanan = $this->request->getPost('deskripsilayanan');

        if (empty($namaLayanan)) {
            return redirect()->to('/cms/service/')->with('error', 'Nama layanan tidak boleh kosong');
        }

        if (strlen(strval($namaLayanan)) > 1024) {
            return redirect()->to('/cms/service/')->with('error', 'Nama layanan tidak boleh lebih dari 1024 karakter');
        }

        if (empty($deskripsiLayanan)) {
            return redirect()->to('/cms/service/')->with('error', 'Deskripsi layanan tidak boleh kosong');
        }

        $data = [
            'namalayanan' => $namaLayanan,
            'deskripsilayanan' => $deskripsiLayanan,
        ];

        $this->LayananModel->where('idlayanan', $idlayanan)->set($data)->update();

        return redirect()->to('/cms/service')->with('success', 'Item layanan berhasil diperbarui!');
    }
    public function serviceDelete($idlayanan)
    {
        $result = $this->LayananModel->where('idlayanan', $idlayanan)->delete();
        if ($result) {
            return redirect()->to('/cms/service')->with('success', 'Item service berhasil dihapus!');
        } else {
            return redirect()->to('/cms/service')->with('error', 'Terjadi kesalahan saat menghapus item service.');
        }
    }
}
