let modalDetailClient = document.getElementById('myModalDetailClient');
let logoImage = document.getElementById('logoImage');
let modalImage = document.getElementById('modalImage')
let modalClientName = document.getElementById('ModalclientName')

let closeButton = document.getElementById("closeDetail");

closeButton.addEventListener('click', function() {
    modalDetailClient.style.display = "none";
});

window.addEventListener('click', function(event) {
    if (event.target == modalDetailClient) {
        modalDetailClient.style.display = "none";
    }
});