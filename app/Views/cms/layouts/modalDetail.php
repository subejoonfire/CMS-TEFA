<div id="myModalDetailClient" class="modal">
    <div class="modal-content">
        <span id="closeDetail" class="close">&times;</span>
        <div class="client-form-header">
            <?php if (session('type') == 'client') : ?>
                <h2>Detail Klien</h2>
            <?php elseif (session('type') == 'photo') : ?>
                <h2>Detail Foto Konten</h2>
            <?php elseif (session('type') == 'portfolio') : ?>
                <h2>Detail Portofolio</h2>
            <?php elseif (session('type') == 'service') : ?>
                <h2>Detail Layanan</h2>
            <?php endif ?>
        </div>
        <?php if (session('type') == 'client') : ?>
            <form id="clientForm" method="post" action="<?= base_url('cms/client/edit/' . session('idklien')) ?>" enctype="multipart/form-data">
                <div class="modal-detail-logo-container">
                    <label for="modalImage">Logo Klien:</label>
                    <img id="modalImage" src="<?= base_url('img/klien/' . session('logoklien')) ?>" alt="" width="200">
                </div>
                <input type="file" id="logo" name="logoklien">
                <br>
                <div class="modal-client-container">
                    <label for="ModalclientName">Nama Klien:</label>
                    <input type="text" class="namaklien" value="<?= session('namaklien') ?>" id="ModalclientName" name="namaklien">
                </div>
                <div>
                    <button type="submit" class="save" id="saveClient">Simpan</button>
                </div>
            </form>
        <?php endif; ?>
        <?php if (session('type') == 'photo') : ?>
            <form id="clientForm" method="post" action="<?= base_url('cms/photo/edit/' . session('idfoto')) ?>" enctype="multipart/form-data">
                <div class="modal-detail-logo-container">
                    <label for="modalImage">Logo Klien:</label>
                    <table>
                        <tbody>
                            <?php
                            $FotoModel = new \App\Models\Foto();
                            $data = $FotoModel->where('idportofolio', session('idportofolio'))->findAll();
                            foreach ($data as $row) :
                            ?>
                                <tr>
                                    <th><img id="modalImage" src="<?= base_url('img/konten/' . $row['foto']) ?>" alt="" width="150"></th>
                                    <th><a class="material-symbols-outlined" href="<?= base_url('cms/photo/detailDelete/' . session('idfoto')) ?>" style="color:black">delete</a></th>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </form>
        <?php endif; ?>
        <?php if (session('type') == 'portfolio') : ?>
            <div class="portfolio-form-header">
                <h2>Tambah Foto Website</h2>
            </div>
            <form enctype="multipart/form-data" action="<?= base_url('cms/portfolio/edit/' . session('idportofolio')) ?>" method="POST">
                <div class="website-name-container">
                    <span>Nama Website :</span>
                    <input type="text" name="namawebsite" value="<?= session('namawebsite') ?>">
                </div>
                <div class="website-show-container">
                    <span>Foto Website :</span>
                    <input type="file" class="exception" name="foto">
                </div>
                <div class="website-show-container">
                    <span>Deskripsi Website :</span>
                    <textarea name="deskripsiwebsite" id="" cols="30" rows="40"><?= session('deskripsiwebsite') ?></textarea>
                </div>
                <div class="website-link-container">
                    <span>Link Website :</span>
                    <input type="text" name="linkwebsite" value="<?= session('linkwebsite') ?>">
                </div>
                <button type="submit" class="save">Simpan</button>
            </form>
        <?php endif; ?>
        <?php if (session('type') == 'service') : ?>
            <form method="POST" action="<?= base_url('cms/service/edit/' . session('idlayanan')) ?>">
                <div class="service-name-container">
                    <span>Nama Layanan :</span>
                    <input type="text" name="namalayanan" value="<?= session('namalayanan') ?>">
                </div>
                <div class="service-show-container">
                    <span>Deskripsi Layanan :</span>
                    <textarea name="deskripsilayanan" id="" cols="30" rows="40"><?= session('deskripsilayanan') ?></textarea>
                </div>
                <br>
                <br>
                <button type="submit" class="save">Simpan</button>
            </form>
        <?php endif; ?>
    </div>
</div>