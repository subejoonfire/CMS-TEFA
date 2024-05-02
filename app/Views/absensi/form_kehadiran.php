<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kehadiran</title>
    <link rel="stylesheet" href="<?= base_url('/css/absensi/form_kehadiran.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/absensi/template.css') ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body>
    <div class="container">
        <div class="popup" id="my-popup">
            <div class="head-popup">
                <h1>Perhatian!</h1>
            </div>
            <div class="body-popup">
                <span>Anda akan keluar pada</span>
                <span><?= date('Y-m-d H:i:s') ?></span>
                <br>
                <br>
                <div class="options">
                    <form action="<?= base_url('absensi/keluarAction') ?>" method="get">
                        <button type="submit" class="my-button">Ya</button>
                    </form>
                    <button type="submit" onclick="hidePopup()" class="my-button">Tidak</button>
                </div>
            </div>
        </div>
        <div class="head-container">
            <h1>Form Kehadiran</h1>
        </div>        
        <div id="presensichecked" class="ucapanwkwk">
            <h3>Anda telah melakukan Presensi</h3>
        </div>
        <div id="ucapanwkwk" class="ucapanwkwk">
            <h3>Terima Kasih telah Hadir</h3>
        </div>
        <div class="login">
            <a href="<?= base_url('absensi/logout') ?>">Logout</a>
        </div>
        <div class="body-container">
            <?php if (session('error')) : ?>
                <div style="text-align: center;"><?= session('error') ?></div>
            <?php endif ?>
            <br>
            <br>
            <!-- <a href="#" onclick="navigator.geolocation.getCurrentPosition(showPosition, showError)">get Loc</a> -->
            <form action="<?= base_url('absensi/kehadiranAction') ?>" method="post">
                <div class="nama-container">
                    <span> Nama :</span>
                    <input type="text" name="namamhs" value="<?= session('usernamee') ?>" readonly id="">
                </div>
                <div class="submit-button">
                    <!-- <input type="text" id="location"> -->
                    <br>
                    <div class="map" id="map"></div>
                    <input type="text" style="display:none" id="locationStatus" name="locationStatus">
                    <br>
                    <button id="button" type="submit" class="my-button">Hadir</button>
                </div>
            </form>
            <div class="keluar-button">
                <button id="keluar-button" class="my-button" onclick="showPopup()">Keluar</button>
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const popup = document.getElementById('my-popup');

    function showPopup() {
        popup.classList.add('show');
    }

    function hidePopup() {
        popup.classList.remove('show');
    }
</script>
<script>
    const x = document.getElementById("location");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.value = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        var map = L.map('map').setView([latitude, longitude], 16);

        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 19,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);
        // var marker = L.marker([-3.7538960567915205, 114.76716149988314]).addTo(map);

        // var circle = L.circle([latitude, longitude], {
        var circle = L.circle([-3.7538960567915205, 114.76716149988314], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 75
        }).addTo(map);

        var isMarkerInsideCircle = circle.getBounds().contains(marker.getLatLng());


        const button = document.getElementById("button");
        const keluarButton = document.getElementById("keluar-button");
        const locationStatus = document.getElementById("locationStatus");
        button.disabled = true
        if (isMarkerInsideCircle) {
            locationStatus.value = "true"
            button.disabled = false
            keluarButton.disabled = false
        } else {
            locationStatus.value = "false"
            keluarButton.disabled = true
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        navigator.geolocation.getCurrentPosition(showPosition, showError);
                    } else {
                        x.value = "User denied the request for Geolocation.";
                    }
                });
                break;
            case error.POSITION_UNAVAILABLE:
                x.value = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                x.value = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                x.value = "An unknown error occurred.";
                break;
        }
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var kehadiranStatus = <?= json_encode(session('kehadiranStatus')) ?>;
        var keluarStatus = <?= json_encode(session('keluarStatus')) ?>;
        const keluarButton = document.getElementById("keluar-button");
        const ucapanwkwk = document.getElementById('ucapanwkwk');
        const presensichecked = document.getElementById('presensichecked');
        const button = document.getElementById("button");
        ucapanwkwk.hidden = true
        presensichecked.hidden = true
        keluarButton.hidden = true;
        button.hidden = false
        if (kehadiranStatus === true) {
            presensichecked.hidden = false
            button.hidden = true
            keluarButton.hidden = false;
        }
        if (keluarStatus === true) {
            presensichecked.hidden = true
            ucapanwkwk.hidden = false
            button.hidden = true
            keluarButton.hidden = true;
        }
    });
</script>

</html>