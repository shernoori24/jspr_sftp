$(document).ready(function() {
    $('#abonner_form').on('submit', function(e) { // Utilisez l'ID correct du formulaire
        e.preventDefault(); // Empêche la soumission normale du formulaire
        $('#loading-animation-subscriber').show();

        $.ajax({
            url: '', // URL de l'action du formulaire
            type: 'POST',
            data: $(this).serialize(), // Sérialise les données du formulaire
            dataType: 'json', // Indique que la réponse attendue est du JSON
            success: function(response) {

                // Masquer le loading
                $('#loading-animation-subscriber').hide();


                if (response.success) {
                    // Afficher le message de succès
                    $('#sent-message-subscriber').text(response.message).show();
                    $('#error-message-subscriber').hide(); // Masquer le message d'erreur

                } else {
                    // Afficher le message d'erreur
                    $('#error-message-subscriber').text(response.message).show();
                    $('#sent-message-subscriber').hide(); // Masquer le message de succès
                }
            },
            error: function(xhr, status, error) {

                // Masquer le loading
                $('#loading-animation-subscriber').hide();

                // Gérer les erreurs de connexion
                $('#error-message-subscriber').text('Une erreur s\'est produite lors de la connexion : ' + error).show();
                $('#sent-message-subscriber').hide(); // Masquer le message de succès
            }
        });
    });
});