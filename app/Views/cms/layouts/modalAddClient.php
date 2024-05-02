<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="client-form-header">
            <h2>Tambah Klien</h2>
        </div>
        <form id="clientForm" method="post" action="<?= base_url('cms/client/create') ?> " enctype="multipart/form-data">
            <div class="modal-logo-container">
                <label for="logo">Logo:</label>
                <input type="file" id="logo" name="logoklien">
            </div>
            <div class="modal-client-container">
                <label for="clientName">Nama Klien:</label>
                <input type="text" class="namaklien" id="clientName" name="namaklien">
            </div>
            <button type="submit" class="save" id="saveClient">Simpan</button>
        </form>
    </div>
</div>