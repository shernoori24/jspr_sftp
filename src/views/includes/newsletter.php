<!-- Section Newsletter -->
<div class="footer-newsletter">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h4>Ne loupez pas les nouvelles activités.</h4>
                <p>Restez à jour sur nos événements, sorties et projets en vous inscrivant dès maintenant ! Ne
                    manquez pas les dernières nouvelles.</p>
                <!-- Formulaire d'inscription à la newsletter -->
                <div class="my-3">
                    <div id="loading-animation-subscriber" class="loading-animation">Chargement</div>
                    <div id="error-message-subscriber" class="error-message" style="display: none;"></div>
                    <div id="sent-message-subscriber" class="sent-message" style="display: none;"></div>
                </div>
                <form id="abonner_form" action="" method="post">

                    <input type="email" name="email_pour_ajouter_en_subscriber" placeholder="Votre email" required>
                    <input type="submit" value="Envoyer">
                    <div id="newsletter-feedback"></div> <!-- Zone de retour d'information -->
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js pour envoyer le formulaie par ajax -->
<script src="assets/js/ajax/abonnes.js"></script>