<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klien</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/photo.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalAddPhoto.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalDetail.css') ?>">
</head>

<body>
    <?php include 'layouts/modalAddPhoto.php';
    if (session('detail', TRUE)) {
        include 'layouts/modalDetail.php';
    }
    ?>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="photo-header-container">
                <div class="add-button-container">
                    <button type="submit" id="addPhotoButton">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="add-button-text">Tambah Foto Website</span>
                    </button>
                </div>
            </div>
            <div class="photo-body-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="websitename">Nama Website</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modelFoto = new \App\Models\Foto();
                        $data = $modelFoto->select('*')->distinct()->join('portofolio', 'portofolio.idportofolio = foto.idportofolio', 'inner')->groupBy('foto.idportofolio')->findAll();
                        $count = 1;
                        foreach ($data as $row) :
                        ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <th><a href="<?= base_url('cms/photo/detail/' . $row['idfoto']) ?>"><?= $row['namawebsite'] ?></a></th>
                                <th>
                                    <?php
                                    $photo = $modelFoto->where('idportofolio', $row['idportofolio'])->findAll();
                                    foreach ($photo as $row) :
                                    ?>
                                        <img src="<?= base_url('img/konten/' . $row['foto']) ?>" height="100" alt="">
                                    <?php endforeach ?>
                                </th>
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
    <script src="<?= base_url('js/modalAddPhoto.js') ?>"></script>
    <script src="<?= base_url('js/modalDetailPhoto.js') ?>"></script>
</footer>

</html>