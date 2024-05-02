<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klien</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/client.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalAddClient.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalDetail.css') ?>">
</head>

<body>
    <?php include 'layouts/modalAddClient.php';
    if (session('detail', TRUE)) {
        include 'layouts/modalDetail.php';
    }
    ?>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="client-header-container">
                <div class="add-button-container">
                    <button type="submit" id="addClientButton">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="add-button-text">Tambah Klien</span>
                    </button>
                </div>
            </div>
            <div class="client-body-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="logo">Logo</th>
                            <th>Nama Klien</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modelKlien = new App\Models\Klien();
                        $data = $modelKlien->findAll();
                        $count = 1;
                        foreach ($data as $row) :
                        ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <input type="text" id="idklien" value="<?= $row['idklien'] ?>" hidden>
                                <th class="logo"><img id="logoImage" src="<?= base_url('img/klien/' . $row['logoklien']) ?>" height="100" alt=""></th>
                                <th><a href="<?= base_url('cms/client/detail/' . $row['idklien']) ?>" id="detailClientButton"><?= $row['namaklien'] ?></a></th>
                                <th><a href="<?= base_url('cms/client/delete/' . $row['idklien']) ?>" class="material-symbols-outlined">delete</a></th>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include 'layouts/footer.php' ?>
    <script src="<?= base_url('js/modalAddClient.js') ?>"></script>
    <script src="<?= base_url('js/modalDetailClient.js') ?>"></script>
</footer>

</html>