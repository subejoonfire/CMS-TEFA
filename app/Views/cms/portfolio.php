<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klien</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/portfolio.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalAddPortfolio.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/modalDetail.css') ?>">
</head>

<body>
    <?php include 'layouts/modalAddPortfolio.php';
    if (session('detail', TRUE)) {
        include 'layouts/modalDetail.php';
    }
    ?>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="portfolio-header-container">
                <div class="add-button-container">
                    <button type="submit" id="addPortfolioButton">
                        <span class="material-symbols-outlined">
                            add
                        </span>
                        <span class="add-button-text">Tambah Website</span>
                    </button>
                </div>
            </div>
            <div class="portfolio-body-container">
                <table>
                    <thead>
                        <tr>
                            <th class="number">No</th>
                            <th class="websitename">Nama Website</th>
                            <th class="websitename">Tampilan Website</th>
                            <th class="websitename">Deskripsi Website</th>
                            <th class="websitename">Link Website</th>
                            <th class="websitename">Tanggal</th>
                            <th class="websitename">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $modelPortofolio = new \App\Models\Portofolio();
                        $data = $modelPortofolio->findAll();
                        $count = 1;
                        foreach ($data as $row) :
                        ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <th><a href="<?= base_url('cms/portfolio/detail/' . $row['idportofolio']) ?>"><?= $row['namawebsite'] ?></a></th>
                                <th>
                                    <img src="<?= base_url('img/portofolio/' . $row['foto']) ?>" width="150" alt="">
                                </th>
                                <th><?= $row['deskripsiwebsite'] ?></th>
                                <th><?= $row['linkwebsite'] ?></th>
                                <th><?= $row['tanggal'] ?></th>
                                <th><a href="<?= base_url('cms/portfolio/delete/' . $row['idportofolio']) ?>" class="material-symbols-outlined">delete</a></th>
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
    <script src="<?= base_url('js/modalAddPortfolio.js') ?>"></script>
    <script src="<?= base_url('js/modalDetailPortfolio.js') ?>"></script>
</footer>


</html>