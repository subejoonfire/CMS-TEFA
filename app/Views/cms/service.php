<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klien</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/service.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalAddService.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalDetail.css') ?>">
</head>

<body>
    <?php include 'layouts/modalAddService.php';
    if (session('detail', TRUE)) {
        include 'layouts/modalDetail.php';
    } ?>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="service-header-container">
                <div class="add-button-container">
                    <button type="submit" id="addServiceButton">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="add-button-text">Tambah Layanan</span>
                    </button>
                </div>
            </div>
            <div class="service-body-container">
                <table>
                    <thead>
                        <tr>
                            <th class="websitename">Nama Layanan</th>
                            <th class="websitename">Deskripsi Layanan</th>
                            <th class="websitename">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modelLayanan = new \App\Models\Layanan();
                        $data = $modelLayanan->findAll();
                        $count = 1;
                        foreach ($data as $row) :
                        ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <th><a href="<?= base_url('cms/service/detail/' . $row['idlayanan']) ?>"><?= $row['namalayanan'] ?></a></th>
                                <th><?= $row['deskripsilayanan'] ?></th>
                                <th><a href="<?= base_url('cms/service/delete/' . $row['idlayanan']) ?>" class="material-symbols-outlined">delete</a></th>
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
    <script src="<?= base_url('js/modalAddService.js') ?>"></script>
    <script src="<?= base_url('js/modalDetailPortfolio.js') ?>"></script>
</footer>

</html>