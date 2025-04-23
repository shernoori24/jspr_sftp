$(document).ready(function() {
    $('#contact-form').on('submit', function(e) { // Utilisez l'ID correct du formulaire
        e.preventDefault(); // Empêche la soumission normale du formulaire
        $('#loading-animation-contact').show();

        $.ajax({
            url: 'accueil', // URL de l'action du formulaire
            type: 'POST',
            data: $(this).serialize(), // Sérialise les données du formulaire
            dataType: 'json', // Indique que la réponse attendue est du JSON
            success: function(response) {

                // Masquer le loading
                $('#loading-animation-contact').hide();


                if (response.success) {
                    // Afficher le message de succès
                    $('#sent-message-contact').text(response.message).show();
                    $('#error-message-contact').hide(); // Masquer le message d'erreur

                } else {
                    // Afficher le message d'erreur
                    $('#error-message-contact').text(response.message).show();
                    $('#sent-message-contact').hide(); // Masquer le message de succès
                }
            },
            error: function(xhr, status, error) {

                // Masquer le loading
                $('#loading-animation-contact').hide();

                // Gérer les erreurs de connexion
                $('#error-message-contact').text('Une erreur s\'est produite lors de la connexion : ' + error).show();
                $('#sent-message-contact').hide(); // Masquer le message de succès
            }
        });
    });
});