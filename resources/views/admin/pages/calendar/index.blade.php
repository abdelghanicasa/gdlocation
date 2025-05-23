@extends('admin.app') {{-- Remplace "admin.layouts.app" par le chemin exact de ton fichier de layout --}}

@section('content')

<div class="row row-eq-height">

    <div class="col-md-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title text-light">Calendrier des réservations</h4>
                </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <!-- <a href="{{ route('admin.calendar.list') }}" class="btn btn-primary"><i class="ri-add-line mr-2"></i>Créer une réservation</a> -->
                </div>
            </div>
            <div class="iq-card-body">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour créer/modifier un événement -->
<div id="eventModal" class="modal" style="z-index: 999;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle">Ajouter une Réservation</h2>
        <form id="eventForm">
            @csrf
            <input type="hidden" id="eventId">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom:</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="tel">Téléphone:</label>
                        <input type="tel" id="tel" name="tel" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <!-- <label for="title">Titre:</label> -->
                        <input type="hidden" id="title" name="title" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="scooter_id">Scooter:</label>
                        <select name="scooter_id" id="scooter_id" class="form-control" required>
                            <option value="">Sélectionner un scooter</option>
                            @foreach ($scooters as $scooter)
                            <option value="{{ $scooter->id }}">{{ $scooter->caracteristiques }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" id="montant_input" value="" name="montant" class="form-control" readonly>
                        <p>Montant total: <span
                                class="bold"
                                style="  
                                    color: white;
                                    font-size: 43px;
                                    padding-left: 20px;"
                                id="montant_display">
                                0</span> <small>€</small>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="date">Date départ:</label>
                        <input type="date" id="start" name="start" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="start_time">Heure de début :</label>
                        <select id="start_time" name="start_time" class="form-control">
                            @for ($hour = 8; $hour <= 19; $hour++)
                                <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date de retour:</label>
                        <input type="date" id="end" name="end" class="form-control" required>
                    </div>

                    <div class="form-group">
                    <label for="end_time">Heure de fin :</label>
                    <select id="end_time" name="end_time" class="form-control">
                        @for ($hour = 8; $hour <= 19; $hour++)
                            <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                            <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                        @endfor
                    </select>
                </div>

                    <div class="form-group">
                        <label for="nombre_jours">Nombre de jours:</label>
                        <input type="number" id="nombre_jours" name="nombre_jours" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <!-- <label for="description">Description:</label> -->
                        <input type="hidden" id="description" value="..." name="description" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="eventColor">Couleur:</label>
                        <input type="color" id="color" value="#fff">
                    </div>
                    <div>

                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-secondary" id="SaveBtn">Enregistrer</button>
                <button type="button" id="deleteEvent" class="btn btn-danger"><i class="fa fa-trash "></i></button>
                <button type="button" id="cancelEvent"  class="btn btn-light">Annuler</button>
            </div>
        </form>
    </div>
</div>


@push('scripts')

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    document.querySelectorAll('#start_date, #end_date, #scooter_id').forEach(el => {
        el.addEventListener('change', () => {
            const start = document.getElementById('start').value;
            const end = document.getElementById('end').value;
            const scooterId = document.getElementById('scooter_id').value;
            const nbjours = document.getElementById("nombre_jours").value;

            if (start && end && scooterId) {
                fetch(`/panel/calculate-price?scooter_id=${scooterId}&from_date=${start}&to_date=${end}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.price) {
                            total = nbjours * data.price;
                            document.getElementById('montant_display').innerText = total;
                            document.getElementById('montant_input').value = total; // Mettre à jour l'input hidden aussi
                        } else {
                            document.getElementById('montant_display').innerText = 'Erreur de Tarif';
                            document.getElementById('montant_input').value = '';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        document.getElementById('montant').innerText = '0 NaN';
                    });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Configuration CSRF pour AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

    // Fonction pour calculer le prix
    function calculatePrice() {
        const start = document.getElementById('start').value;
        const end = document.getElementById('end').value;
        const scooterId = document.getElementById('scooter_id').value;
        const nbjours = parseInt(document.getElementById("nombre_jours").value);

        if (start && end && scooterId && nbjours) {
            fetch(`/panel/calculate-price?scooter_id=${scooterId}&from_date=${start}&to_date=${end}`)
                .then(res => res.json())
                .then(data => {
                    if (data.price) {
                        const total = nbjours * data.price;
                        document.getElementById('montant_display').innerText = total;
                        document.getElementById('montant_input').value = total;
                    } else {
                        document.getElementById('montant_display').innerText = 'Erreur de tarif';
                        document.getElementById('montant_input').value = '';
                    }
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('montant_display').innerText = 'Erreur';
                    document.getElementById('montant_input').value = '';
                });
        }
    }


    // Fonction pour calculer le nombre de jours
    function calculateDays() {
        const startDateStr = document.getElementById("start").value;
        const endDateStr = document.getElementById("end").value;
        const startTime = document.getElementById("start_time").value;
        const endTime = document.getElementById("end_time").value;
        const scooterId = document.getElementById("scooter_id").value;

        if (startDateStr && endDateStr && startTime && endTime && scooterId) {
            const startDateTime = new Date(`${startDateStr}T${startTime}`);
            const endDateTime = new Date(`${endDateStr}T${endTime}`);

            const diffMs = endDateTime - startDateTime;
            const diffHours = diffMs / (1000 * 60 * 60);

            let nbJours = 1;
            if (diffHours > 24) {
                nbJours = 2;
            }

            document.getElementById("nombre_jours").value = nbJours;
            calculatePrice();
        }
    }


    // Récupération des éléments du modal
    var modal = document.getElementById("eventModal");
    var span = document.getElementsByClassName("close")[0];
    var eventForm = document.getElementById("eventForm");
    var deleteBtn = document.getElementById("deleteEvent");
    var cancelBtn = document.getElementById("cancelEvent");

    // Initialisation du calendrier
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        slotMinTime: '07:00:00', 
        slotMaxTime: '22:00:00',
        locale: 'fr',
        eventDisplay: 'block', // Change le mode d'affichage
        allDayText: '', // Cache le texte "Toute la journée"
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        editable: false,
        selectable: true,
        dayMaxEvents: true,
        events: "{{ route('events.get') }}",
        eventContent: function(arg) {
            const formatTime = (timeStr) => {
                if (!timeStr) return '';
                return timeStr.includes(':') ? timeStr.split(':').slice(0, 2).join(':') : timeStr;
            };

            const title = arg.event.title || '';
            const startTime = formatTime(arg.event.extendedProps?.start_time || '');
            const endTime = formatTime(arg.event.extendedProps?.end_time || '');
            const prenom = arg.event.extendedProps?.prenom || '';
            const nom = arg.event.extendedProps?.nom || '';
            const montant = arg.event.extendedProps?.montant || '';
            const scooterId = arg.event.extendedProps?.scooter_id || '';
            const dateRetour = arg.event.extendedProps?.custom_end || '';

            console.log('Date retour :', dateRetour);

            // Trouver modèle du scooter
            let scooterModel = '';
            const scooterSelect = document.getElementById('scooter_id');
            if (scooterSelect) {
                const selectedOption = scooterSelect.querySelector(`option[value="${scooterId}"]`);
                if (selectedOption) {
                    scooterModel = selectedOption.textContent;
                }
            }

            // Texte principal
            const fullName = `${prenom} ${nom}`.trim();
            const isStart = arg.event.id.endsWith('_start');
            const isEnd = arg.event.id.endsWith('_end');
            /* */
            
            /* */
            let content = '';

            if (isStart) {
                content = `D : ${fullName} ${scooterModel} à ${startTime}`;
            } else if (isEnd) {
                content = `R : ${fullName} ${scooterModel} à ${endTime}`;
            }

            if (arg.view.type === 'listWeek') {
                return {
                    html: `<div class="fc-list-event-title">${content}</div>`
                };
            }

            return {
                html: `<div class="fc-event-time">${content}</div>`
            };
        },

        eventClick: function(info) {
            console.log(info.event.extendedProps);
            // openModal(info.event);
        },
        select: function(info) {
            openModal({
                title: 'Nouvelle réservation',
                start: info.start,
                end: info.end,
                allDay: info.allDay
            });
        },
        eventDrop: function(info) {
            updateEvent(info.event);
        },
        eventResize: function(info) {
            updateEvent(info.event);
        }
    });

    calendar.render();

    // Fonction pour ouvrir le modal
    function openModal(event) {
        eventForm.reset();
        document.getElementById("modalTitle").innerText = event.id ? "Modifier la réservation" : "Ajouter une réservation";
        document.getElementById("eventId").value = event.id || '';

        const saveBtn = document.getElementById("SaveBtn");
        const eventId = event.id;

        if (event.id) {

            
            const editUrl = "{{ route('admin.calendar.edit', ['id' => '__id__']) }}".replace('__id__', eventId);
            saveBtn.textContent = "Modifier"; // Change le texte du bouton en mode édition
            saveBtn.onclick = function () {
                eventForm.action = editUrl;  // Assurez-vous que l'action du formulaire correspond à la route d'édition
                // eventForm.submit();  // Soumettre le formulaire pour modifier l'événement
            };


            // Remplir les champs pour une modification
            document.getElementById("nom").value = event.extendedProps?.nom || '';
            document.getElementById("prenom").value = event.extendedProps?.prenom || '';
            document.getElementById("email").value = event.extendedProps?.email || '';
            document.getElementById("tel").value = event.extendedProps?.tel || '';
            document.getElementById("title").value = event.title || '';
            document.getElementById("description").value = event.extendedProps?.description || '';
            document.getElementById("nombre_jours").value = event.extendedProps?.nombre_jours || 1;
            document.getElementById("scooter_id").value = event.extendedProps?.scooter_id || '';
            document.getElementById("color").value = event.extendedProps?.color || '';
            document.getElementById("montant_display").innerText = event.extendedProps?.montant || '0';
            document.getElementById("montant_input").value = event.extendedProps?.montant || '0';
            document.getElementById("end").value = event.extendedProps?.custom_end || '';

            if (event.start) {
            const startDate = new Date(event.start);
            document.getElementById("start").value = startDate.toISOString().split('T')[0];
            
            const startTime = event.extendedProps.start_time;
            const formattedStartTime = startTime.split(':').slice(0, 2).join(':');
            const startSelect = document.getElementById("start_time");
            
            // Trouver et sélectionner l'option correspondante
            for (let i = 0; i < startSelect.options.length; i++) {
                if (startSelect.options[i].value === formattedStartTime) {
                    startSelect.selectedIndex = i;
                    break;
                }
            }
        }

        if (event.end) {
            const endDate = new Date(event.end);
            console.lo(endDate);
            // document.getElementById("end").value = endDate.toISOString().split('T')[0];
            document.getElementById("end").value = event.extendedProps?.custom_end || '';
            const endTime = event.extendedProps.end_time;
            const formattedEndTime = endTime.split(':').slice(0, 2).join(':');
            const endSelect = document.getElementById("end_time");
            
            // Trouver et sélectionner l'option correspondante
            for (let i = 0; i < endSelect.options.length; i++) {
                if (endSelect.options[i].value === formattedEndTime) {
                    endSelect.selectedIndex = i;
                    break;
                }
            }
        }
        } else {
            // Valeurs par défaut pour une nouvelle réservation
            document.getElementById("title").value = "Nouvelle réservation";

            if (event.start) {
                const startDate = new Date(event.start);
                document.getElementById("start").value = startDate.toISOString().split('T')[0];
                document.getElementById("start_time").value = '09:00';

                const endDate = new Date(event.start);
                endDate.setDate(endDate.getDate() + 1);
                document.getElementById("end").value = endDate.toISOString().split('T')[0];
                document.getElementById("end_time").value = '17:00';
            }
        }

        calculateDays();
        deleteBtn.style.display = event.id ? "inline-block" : "none";
        modal.style.display = "block";
    }

    // Écouteurs d'événements pour les champs qui affectent le prix
    const priceInputs = ['start', 'end', 'start_time', 'end_time', 'scooter_id'];
    priceInputs.forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            calculateDays();
        });
    });

    // Écouteurs supplémentaires pour les champs de date
    document.getElementById('start').addEventListener('input', function() {
        calculateDays();
    });
    
    document.getElementById('end').addEventListener('input', function() {
        calculateDays();
    });

    // Fermeture du modal
    span.onclick = cancelBtn.onclick = function() {
        modal.style.display = "none";
    };

     // Gestion de la soumission du formulaire
    eventForm.addEventListener('submit', function(e) {
        e.preventDefault();

        $('.error-message').remove();
        $('.form-control').removeClass('is-invalid');

        const eventId = document.getElementById("eventId").value;
        const eventData = {
            nom: document.getElementById("nom").value,
            prenom: document.getElementById("prenom").value,
            email: document.getElementById("email").value,
            tel: document.getElementById("tel").value,
            start: document.getElementById("start").value,
            start_time: document.getElementById("start_time").value,
            end: document.getElementById("end").value,
            end_time: document.getElementById("end_time").value,
            nombre_jours: document.getElementById("nombre_jours").value,
            title: document.getElementById("title").value,
            description: document.getElementById("description").value,
            scooter_id: document.getElementById("scooter_id").value,
            color: document.getElementById("color").value,
            montant: document.getElementById("montant_input").value
        };

        // Validation des dates
        const startDateTime = new Date(`${eventData.start}T${eventData.start_time}`);
        const endDateTime = new Date(`${eventData.end}T${eventData.end_time}`);

        if (endDateTime <= startDateTime) {
            Swal.fire({
                title: 'Erreur',
                text: 'La date/heure de retour doit être après la date/heure de départ',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        const url = eventId ? `/panel/events/${eventId}` : "{{ route('events.store') }}";
        const method = eventId ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(eventData),
            contentType: 'application/json',
            success: function(response) {
                showSuccess(eventId ? 'Réservation modifiée avec succès' : 'Réservation créée avec succès');
                
                if (eventId) {
                    const event = calendar.getEventById(eventId);
                    if (event) {
                        event.setProp('title', response.title);
                        event.setStart(response.start);
                        event.setEnd(response.end);
                        // Mettre à jour les autres propriétés...
                    }
                } else {
                    calendar.addEvent({
                        id: response.id,
                        title: response.title,
                        start: response.start,
                        end: response.end,
                        extendedProps: {
                            // Toutes les propriétés étendues...
                        }
                    });
                }
            },
            error: showError
        });
    });

    // Fonctions utilitaires
    function showSuccess(message) {
        Swal.fire({
            title: 'Succès!',
            text: message,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            modal.style.display = "none";
            location.reload();
        });
    }

    function showError(xhr) {
        let errorMessage = 'Une erreur est survenue';

        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }


        // Gestion des erreurs...
        Swal.fire({
            title: 'Erreur',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    function updateEvent(event) {
        const eventData = {
            start: event.start ? event.start.toISOString() : null,
            end: event.end ? event.end.toISOString() : null
        };

        $.ajax({
            url: "/events/" + event.id,
            type: "PUT",
            data: JSON.stringify(eventData),
            contentType: 'application/json'
        });
    }

    // Fermeture du modal si clic en dehors
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    let selectedEventId = null;

    // Suppose que tu sélectionnes un événement dans FullCalendar comme ceci :
    calendar.on('eventClick', function(info) {
        selectedEventId = info.event.id;
        $('#deleteEvent').show(); // afficher le bouton par exemple
    });

    // Suppression au clic sur le bouton
    $('#deleteEvent').on('click', function () {
    if (selectedEventId) {
        Swal.fire({
            title: "Confirmer la suppression ?",
            text: "Cet Réservation sera supprimé définitivement.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Oui, supprimer !",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/panel/events/${selectedEventId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Supprimé',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        calendar.getEventById(selectedEventId).remove(); // supprime de l'affichage
                        selectedEventId = null;
                        $('#deleteEvent').hide();
                        document.getElementById("eventModal").style.display = "none"; // ferme le modal
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la suppression.'
                        });
                    }
                });
            }
        });
    }
});

});
</script>
@endpush

<style>
    #calendar {
        max-width: 1650px;
        margin: 0 auto;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #2c2c2c;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    .fc-day-today {
        background-color:#717179bd !important; /* Rouge clair */
    }
    .fc-theme-standard .fc-list-day-cushion {
        background-color: rgba(208, 208, 208, .3);
        background-color: #717179 !important;
    }
    /* Survol d'un événement */
    /* Survol d'une ligne d'événement */
    /* Effet de survol sur la ligne entière de l'événement */
    .fc-list-event:hover {
        background-color:rgb(0, 0, 0) !important; /* Gris clair */
        cursor: pointer;
    }

    /* Effet de survol sur CHAQUE cellule TD de la ligne */
    .fc-list-event:hover td {
        background-color:rgba(0, 0, 0, 0) !important; /* Bleu très clair */
        transition: background-color 0.3s ease;
    }

/* Cellule du temps */
.fc-list-event:hover .fc-list-event-time {
    /* font-weight: bold; */
    color:rgb(255, 255, 255) !important; /* Bleu foncé */
}

/* Cellule du titre */
.fc-list-event:hover .fc-list-event-title a {
    color:rgb(255, 255, 255) !important; /* Bleu */
    text-decoration: underline;
    transition: all 0.2s ease;
}

/* Cellule graphique (point de couleur) */
.fc-list-event:hover .fc-list-event-graphic {
    transform: scale(1.1);
}

/* Point de couleur */
.fc-list-event:hover .fc-list-event-dot {
    transform: scale(1.3); /* Agrandit le point */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}
.fc .fc-toolbar-title {
    font-size: 1.75em;
    margin: 0;
    color: #f8f9fa;
}
</style>
@endsection