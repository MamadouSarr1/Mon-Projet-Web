document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("reservation-form");
    const responseBox = document.getElementById("responseMessage");

    form.addEventListener("submit", function (event) {
        const nom = document.getElementById("nom").value.trim();
        const email = document.getElementById("email").value.trim();
        const destination = document.getElementById("destination").value;
        

        // Vérification simple côté client, SANS empêcher la soumission
        if (!nom || !email || !destination) {
            event.preventDefault(); // Empêche la soumission si vide
            responseBox.innerHTML = '<div class="error">Veuillez remplir tous les champs avant de réserver.</div>';
        } else {
           
            responseBox.innerHTML = `<div class="success">Merci ${nom}, nous allons traiter votre réservation pour ${destination}.</div>`;
          
        }
    });
});
