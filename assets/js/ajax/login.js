$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        e.preventDefault(); // Empêche la soumission normale du formulaire

        $.ajax({
            url: 'klaxon', // URL de l'action du formulaire
            type: 'POST',
            data: $(this).serialize(), // Sérialise les données du formulaire
            dataType: 'json', // Indique que la réponse attendue est du JSON
            success: function(response) {
                if (response.success) {
                    // Redirection en fonction du rôle de l'utilisateur
                    if (response.role === 'master_admin') {
                        window.location.href = 'shamm/evenements';
                    } else {
                        window.location.href = 'shamm/evenements';
                    }
                } else {
                    // Afficher le message d'erreur
                    $('#error-message').text(response.message).show();
                }
            },
            error: function(xhr, status, error) {
                $('#error-message').text('Une erreur s\'est produite lors de la connexion : ' + error).show();
            }
        });
    });
});