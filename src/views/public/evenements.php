<?php
use Controllers\EventsController;

$eventsController = new EventsController();
$events = $eventsController->getAllEvents();

$formattedEvents = array_map(function($event) {
    return [
        'title' => $event['title'],
        'start' => (new DateTime($event['date']))->format('Y-m-d\TH:i:s'),
        'description' => nl2br($event['description']), // Conversion des sauts de ligne
        'adresse' => $event['adresse'],
        'image' => $event['image'] ?? 'aploads/event/event_par_defaut.png'
    ];
}, $events);

include './src/views/includes/header.php';
?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<section class="container mt-5" data-aos="fade-down">
    <h2 class="mb-4 text-center fw-bold">Agenda des Événements</h2>
    <div id="calendar" class="p-3 bg-white rounded shadow"></div>
    
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title" id="eventTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="text-center modal-body">
                    <img id="eventImage" src="" class="mb-3 rounded shadow img-fluid" alt="Image de l'événement" style="max-height: 300px; object-fit: cover;">
                    <div id="eventDescription" class="mb-3 text-muted text-start" style="white-space: pre-line;"></div>
                    <p><strong><i class="fas fa-map-marker-alt"></i> Adresse :</strong> <span id="eventAdresse" class="fw-bold"></span></p>
                    <p class="mt-3"><strong><i class="fas fa-clock"></i> Heure :</strong> <span id="eventTime"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include './src/views/includes/newsletter.php';
include './src/views/includes/footer.php';
include 'src/views/includes/footer_links.php';
?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const events = <?= json_encode($formattedEvents) ?>;
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            events: events,
            eventContent: function(arg) {
                return {
                    html: `
                        <div class="shadow-sm fc-event-card" style="border-radius: 10px; overflow: hidden;">
                            <div class="fc-event-image" style="height: 100px; width: 140px; background: url('${arg.event.extendedProps.image}') no-repeat center center; background-size: cover;"></div>
                            <div class="fc-event-title" style="padding: 8px; font-weight: bold;">
                                ${arg.event.title}
                            </div>
                            <div class="fc-event-time" style="padding: 8px;">
                                <small class="text-muted">${new Date(arg.event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>
                            </div>
                        </div>
                    `
                };
            },
            eventClick: function(info) {
                const modal = document.getElementById('eventModal');
                modal.querySelector('#eventTitle').textContent = info.event.title;
                modal.querySelector('#eventDescription').innerHTML = info.event.extendedProps.description;
                modal.querySelector('#eventAdresse').textContent = info.event.extendedProps.adresse;
                modal.querySelector('#eventImage').src = info.event.extendedProps.image;
                modal.querySelector('#eventTime').textContent = new Date(info.event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                new bootstrap.Modal(modal).show();
            }
        });

        calendar.render();
    });
</script>