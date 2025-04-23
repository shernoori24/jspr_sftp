document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour extraire la section active de l'URL
    function getCurrentSection() {
        const path = window.location.pathname;
        const parts = path.split('/');
        // La partie après 'shamm/' est notre section
        const shammIndex = parts.indexOf('shamm');
        return shammIndex !== -1 && parts.length > shammIndex + 1 ? parts[shammIndex + 1] : '';
    }

    // Mettre à jour les liens actifs
    function updateActiveSidebarLinks() {
        const currentSection = getCurrentSection();
        const sidebarLinks = document.querySelectorAll('#sidebar-admin a');
        
        sidebarLinks.forEach(link => {
            const linkHref = link.getAttribute('href');
            const linkSection = linkHref.split('/').pop();
            
            if (linkSection === currentSection) {
                link.classList.add('active-sidebar');
                link.classList.remove('text-white-50');
                link.classList.add('text-white');
            } else {
                link.classList.remove('active-sidebar');
                link.classList.add('text-white-50');
                link.classList.remove('text-white');
            }
        });
    }

    // Appeler la fonction au chargement
    updateActiveSidebarLinks();
    
    // Optionnel: réagir aux changements d'URL (pour les SPA)
    window.addEventListener('popstate', updateActiveSidebarLinks);
});