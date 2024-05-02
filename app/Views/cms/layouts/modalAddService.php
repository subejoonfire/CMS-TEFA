<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="service-form-header">
            <h2>Tambah Layanan</h2>
        </div>
        <form method="POST" action="<?= base_url('cms/service/create') ?>">
            <div class="service-name-container">
                <span>Nama Layanan :</span>
                <input type="text" name="namalayanan">
            </div>
            <div class="service-show-container">
                <span>Deskripsi Layanan :</span>
                <textarea name="deskripsilayanan" id="" cols="30" rows="40"></textarea>
            </div>
            <br>
            <br>
            <button type="submit" class="save">Simpan</button>
        </form>
    </div>
</div>