<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="client-form-header">
            <h2>Tambah Foto Website</h2>
        </div>
        <form id="clientForm" enctype="multipart/form-data" action="<?= base_url('cms/photo/create') ?>" method="POST">
            <div class="modal-logo-container">
                <label for="website">Pilih Website:</label>
                <select name="idportfolio" id="website">
                    <?php 
                    $FotoModel = new \App\Models\Portofolio();
                    $data = $FotoModel->findAll();
                    foreach ($data as $row) :
                    ?>
                    <option value="<?= $row['idportofolio'] ?>"><?= $row['namawebsite'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="modal-logo-container">
                <label for="logo">Pilih Foto:</label>
                <input type="file" id="logo" name="logo" accept="image/*">
            </div>
            <button type="submit" class="save" id="saveClient">Simpan</button>
        </form>
    </div>
</div>