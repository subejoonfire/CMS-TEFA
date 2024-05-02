<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/counter.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
</head>

<body>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="dashboard-header-container">
                <div class="counter-cards-container">
                    <?php include 'layouts/counter.php' ?>
                </div>
                <div class="welcome-sign">
                    <h1 class="selamat">Selamat</h1>
                    <h1 class="datang">Datang !</h1>
                </div>
            </div>
            <div class="contact-content-container">
                <div class="contact-header-container">
                    <h1>Pesan Terbaru</h1>
                    <span>25 April 2024</span>
                </div>
                <div class="contact-body-container">
                <table>
                    <thead>
                        <tr>
                            <th>Subjek</th>
                            <th>Telepon</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modelKontak = new \App\Models\Kontak();
                        $data = $modelKontak->findAll();
                        foreach (array_keys($data) as $index) :
                            $row = $data[$index];
                        ?>
                            <tr>
                                <th><?= $row['subjek'] ?></th>
                                <th><?= $row['telpon'] ?></th>
                                <th><?= $row['pesan'] ?></th>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>