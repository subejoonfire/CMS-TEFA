<?php
use \App\Models\AbsensiAkun;

$akunModel = new AbsensiAkun();
$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('/css/absensi/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/absensi/odashboard.css') ?>">
</head>

<body>
    <div class="container">
        <div class="head-container">
            <h1>Dashboard</h1>
        </div>
        <div class="body-container">
            <div class="notifications">
                <?php if (session('error')) : ?>
                    <span><?= session('error') ?></span>
                <?php elseif (session('success')) : ?>
                    <span><?= session('success') ?></span>
                <?php endif; ?>
            </div>
            <a class="logoutButton" href="<?= base_url('absensi/logout') ?>">Logout</a>
            <span class="date"><?= $date->format('l, d F Y') ?></span>
            <div class="input-container">
                <table class="input-table">
                    <form action="<?= base_url('/addAkunAction') ?>" method="post">
                        <tbody>
                            <tr>
                                <th>Role :</th>
                                <th>
                                    <select name="role" id="role">
                                        <option value="admin">Admin</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                </th>
                            </tr>
                            <tr id="namamhs">
                                <th>Nama Mahasiswa :</th>
                                <th>
                                    <input name="namamhs" type="text">
                                </th>
                            </tr>
                            <tr>
                                <th>Username :</th>
                                <th>
                                    <input name="username" type="text">
                                </th>
                            </tr>
                            <tr>
                                <th>Password :</th>
                                <th>
                                    <input name="password" type="password">
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>
                                    <button type="submit" class="my-button">Submit</button>
                                </th>
                            </tr>
                        </tbody>
                    </form>
                </table>
                <div class="data-container">
                    <span>Operator</span>
                    <div class="data-operator-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $akunModel->where('role', 'operator')->findAll();
                                foreach ($data as $row) :
                                ?>
                                    <tr>
                                        <th><?= $row['idakun'] ?></th>
                                        <th><?= $row['username'] ?></th>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <span>Admin</span>
                    <div class="data-admin-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $akunModel->where('role', 'admin')->findAll();
                                foreach ($data as $row) :
                                ?>
                                    <tr>
                                        <th><?= $row['idakun'] ?></th>
                                        <th><?= $row['username'] ?></th>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <span>Mahasiswa</span>
                    <div class="data-mahasiswa-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $data = $akunModel->where('role', 'mahasiswa')->join('mahasiswa', 'mahasiswa.idakun = akun.idakun', 'inner')->findAll();
                                foreach ($data as $row) :
                                ?>
                                    <tr>
                                        <th><?= $row['idakun'] ?></th>
                                        <th><?= $row['namamhs'] ?></th>
                                        <th><?= $row['username'] ?></th>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const role = document.getElementById('role')
    const namamhs = document.getElementById('namamhs')
    namamhs.hidden = true;
    role.addEventListener('change', function() {
        const selectedRole = role.value;
        if (selectedRole === 'mahasiswa') {
            namamhs.hidden = false;
        } else {
            namamhs.hidden = true;
        }
    });
</script>

</html>