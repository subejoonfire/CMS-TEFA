<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if (session('error')) :
?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "<?= session('error') ?>",
        });
    </script>
<?php endif ?>
<?php
if (session('success')) :
?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "<?= session('success') ?>",
        });
    </script>
<?php endif ?>