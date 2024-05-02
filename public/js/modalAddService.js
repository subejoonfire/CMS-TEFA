var addButton = document.getElementById('addServiceButton');
var modal = document.getElementById('myModal');

addButton.addEventListener('click', function() {
    modal.style.display = "block";
    console.log('halo')
});

var span = document.getElementsByClassName("close")[0];

span.addEventListener('click', function() {
    modal.style.display = "none";
});

window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});
