<?php

use \App\Models\AbsensiKehadiran;
use \App\Models\AbsensiKeluar;

$kehadiranModel = new AbsensiKehadiran();
$keluarModel = new AbsensiKeluar();
$dataHadir = $kehadiranModel->where('DATE(tanggal)', date('Y-m-d'))->join('mahasiswa', 'kehadiran.idmhs = mahasiswa.idmhs', 'inner')->findAll();
$dataKeluar = $keluarModel->where('DATE(tanggal)', date('Y-m-d'))->join('mahasiswa', 'keluar.idmhs = mahasiswa.idmhs', 'inner')->findAll();
$date = new DateTime();
$date->setDate(date('Y'), date('m'), date('d'));
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('/css/absensi/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/absensi/dashboard.css') ?>">
</head>

<body>
    <div class="container">
        <div class="head-container">
            <h1>Dashboard</h1>
        </div>
        <div class="body-container">
            <a class="logoutButton" href="<?= base_url('absensi/logout') ?>">Logout</a>
            <span class="date"><?= $date->format('l, d F Y') ?></span>
            <div class="table-container">
                <div class="kehadiran-container">
                    <div class="kehadiran-header">
                        <span>Kehadiran</span>
                    </div>
                    <div class="kehadiran-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($dataHadir as $row) :
                                ?>
                                    <tr>
                                        <th><?= $i ?></th>
                                        <th><?= $row['namamhs'] ?></th>
                                        <th><?= date('l, j F Y', strtotime($row['tanggal'])) ?></th>
                                    </tr>
                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="keluar-container">
                    <div class="keluar-header">
                        <span>Keluar</span>
                    </div>
                    <div class="keluar-body">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($dataKeluar as $row) :
                                ?>
                                    <tr>
                                        <th><?= $i ?></th>
                                        <th><?= $row['namamhs'] ?></th>
                                        <th><?= date('l, j F Y', strtotime($row['tanggal'])) ?></th>
                                    </tr>
                                <?php $i++;
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="dates">
                <div class="head-dates">
                    <span>Dates</span>
                </div>
                <div class="body-dates" id="datesContainer" hidden>
                    <?php
                    $dates = $kehadiranModel->distinct()->select('DATE(tanggal) as tanggal')->findAll();
                    foreach ($dates as $row) {
                    ?>
                        <a href="<?= base_url('absensi/dashboardFilter/'), $row['tanggal'] ?>"><?= date('l, j F Y', strtotime($row['tanggal'])) ?></a>
                    <?php
                    }
                    ?>
                </div>
                <a id="toggleShow">Show</a>
            </div>
        </div>
    </div>
</body>
<script>
    var toggleShow = document.getElementById('toggleShow');
    var datesContainer = document.getElementById('datesContainer');
    var toggle = false;

    toggleShow.addEventListener("click", function() {
        if (toggle === false) {
            datesContainer.hidden = false;
            toggleShow.textContent = "Hide";
            toggle = true;
        } else {
            datesContainer.hidden = true;
            toggleShow.textContent = "Show";
            toggle = false;
        }
    });
</script>

</html>