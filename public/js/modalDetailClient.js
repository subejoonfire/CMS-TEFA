let detailClientButton = document.getElementById('detailClientButton');
let modalDetailClient = document.getElementById('myModalDetailClient');
let logoImage = document.getElementById('logoImage');
let clientNameText = detailClientButton.textContent;
let modalImage = document.getElementById('modalImage')
let modalClientName = document.getElementById('ModalclientName')

detailClientButton.addEventListener('click', function() {
    modalDetailClient.style.display = "block";
    modalImage.src = logoImage.src
    modalClientName.value = clientNameText
    console.log(idklien)
});

let closeButton = document.getElementById("closeDetail");

closeButton.addEventListener('click', function() {
    modalDetailClient.style.display = "none";
});

window.addEventListener('click', function(event) {
    if (event.target == modalDetailClient) {
        modalDetailClient.style.display = "none";
    }
});