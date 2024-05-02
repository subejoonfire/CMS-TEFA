<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="portfolio-form-header">
            <h2>Tambah Foto Website</h2>
        </div>
        <form enctype="multipart/form-data" action="<?= base_url('cms/portfolio/create') ?>" method="POST">
            <div class="website-name-container">
                <span>Nama Website :</span>
                <input type="text" name="namawebsite">
            </div>
            <div class="website-show-container">
                <span>Foto Website :</span>
                <input type="file" class="exception" name="foto">
            </div>
            <div class="website-show-container">
                <span>Deskripsi Website :</span>
                <textarea name="deskripsiwebsite" id="" cols="30" rows="40"></textarea>
            </div>
            <div class="website-link-container">
                <span>Link Website :</span>
                <input type="text" name="linkwebsite">
            </div>
            <button type="submit" class="save">Simpan</button>
        </form>
    </div>
</div>