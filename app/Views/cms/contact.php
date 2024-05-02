<?php
$modelKontak = new \App\Models\Kontak();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= base_url('css/cms/sidebar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/contact.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cms/template.css') ?>">
</head>

<body>
    <div class="container">
        <?php include 'layouts/sidebar.php' ?>
        <div class="content-container">
            <div class="contact-body-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Subjek</th>
                            <th>Telepon</th>
                            <th>Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $modelKontak->findAll();
                        $count = 1;
                        foreach (array_keys($data) as $index) :
                            $row = $data[$index];
                        ?>
                            <tr>
                                <th><?= $count++ ?></th>
                                <th><?= $row['nama'] ?></th>
                                <th><?= $row['subjek'] ?></th>
                                <th><?= $row['telpon'] ?></th>
                                <th><?= $row['pesan'] ?></th>
                                <th><a href="<?= base_url('cms/contact/delete/' . $row['idkontak']) ?>" class="material-symbols-outlined">delete</a></th>
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
</footer>

</html>