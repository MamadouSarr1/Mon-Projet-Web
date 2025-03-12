document.getElementById("reservation-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Empêcher le formulaire de se soumettre normalement
    
    // Récupérer les valeurs des champs
    let nom = document.getElementById("nom").value;
    let email = document.getElementById("email").value;
    let destination = document.getElementById("destination").value;

    // Créer une instance XMLHttpRequest pour l'AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "traitement.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Gérer la réponse du serveur
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Afficher la réponse du serveur dans la div "responseMessage"
            document.getElementById("responseMessage").innerHTML = xhr.responseText;
        } else {
            // En cas d'erreur
            document.getElementById("responseMessage").innerHTML = "<p>Il y a eu une erreur lors de la réservation.</p>";
        }
    };

    // Envoyer les données au serveur
    xhr.send("nom=" + encodeURIComponent(nom) + "&email=" + encodeURIComponent(email) + "&destination=" + encodeURIComponent(destination));
});
