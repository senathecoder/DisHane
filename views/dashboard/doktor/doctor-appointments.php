<!-- FullCalendar ve Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.randevu-container {
    max-width: 850px;
    margin: 28px auto 0 auto;
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.10);
    padding: 34px 22px 26px 22px;
    position: relative;
}
.randevu-geri-btn {
    display: inline-flex;
    align-items: center;
    gap: .35em;
    background: #fae2e7;
    color: #b02a37;
    font-weight: 600;
    font-size: 1.04rem;
    border: none;
    border-radius: 16px;
    padding: 6px 15px 6px 11px;
    text-decoration: none;
    box-shadow: 0 1px 5px 0 rgba(176,42,55,0.03);
    transition: background .15s, color .13s;
    position: absolute;
    left: 26px;
    top: 24px;
    z-index: 10;
}
.randevu-geri-btn:hover, .randevu-geri-btn:focus {
    background: #f8cad3;
    color: #871823;
}
.randevu-geri-btn .geri-ikon {
    font-size: 1.13em;
    margin-right: 3px;
}

/* Başlık */
.randevu-title-center {
    text-align: center;
    color: #b02a37;
    font-weight: bold;
    font-size: 2.08rem;
    margin: 0 0 1.1rem 0;
    letter-spacing: .5px;
    padding-top: 8px;
}

/* Seçilen Gün Paneli */
#appointment-details {
    display: none;
    max-width: 650px;
    margin: 0 auto 18px auto;
    padding: 13px 14px 8px 14px;
    background: #f8f9fa;
    border-radius: 12px;
    box-shadow: 0 0 8px rgba(176,42,55,0.07);
}
#appointment-details h5 {
    color: #b02a37;
    font-size: 1.05rem;
    font-weight: bold;
    letter-spacing: .05rem;
}

/* Takvim ayarı */
#calendar {
    margin-top: 12px;
}

/* FullCalendar event kutuları */
.fc-event, .fc-event-dot {
    background-color: #fde4e7 !important;  /* Açık pembe */
    color: #222 !important;                /* Koyu siyah yazı */
    border: 1.2px solid #f1b4b8 !important;
    border-radius: 8px !important;
    font-size: 0.84rem;
    padding: 3px 7px;
    font-weight: 600;
}
.fc-event-title, .fc-event-main {
    color: #222 !important;
    font-weight: 500 !important;
}

.fc-daygrid-day-number, .fc-col-header-cell-cushion {
    color: #b02a37 !important;
    font-weight: 600;
}
.fc-col-header-cell {
    background: #fff6f7 !important;
}
.fc-daygrid-day.fc-day-today {
    background: #fff2f5 !important;
}

.fc-button, .fc-button-primary {
    background: #b02a37 !important;
    border: none !important;
    color: #fff !important;
    border-radius: 7px !important;
    font-weight: 600;
}
.fc-button-primary:not(:disabled):hover, .fc-button-primary:not(:disabled):active, .fc-button-primary:focus {
    background: #871823 !important;
    color: #fff !important;
}

.fc-scrollgrid {
    border-radius: 14px;
    box-shadow: 0 4px 20px 0 rgba(176,42,55,0.06);
    overflow: hidden;
}
.fc-theme-standard .fc-scrollgrid, .fc-theme-standard td, .fc-theme-standard th {
    border-color: #fad6db !important;
}

/* Takvim seçili ve hover günler */
.fc-daygrid-day.fc-day-today,
.fc-daygrid-day.fc-day-selected,
.fc-daygrid-day.fc-day-active {
    background: #fff2f5 !important;
    border-radius: 9px !important;
    box-shadow: 0 2px 8px 0 #b02a3720 !important;
    transition: background 0.18s;
}
.fc-daygrid-day:hover {
    background: #fae2e7 !important;
    border-radius: 9px;
    cursor: pointer;
}

/* Randevu detay tablosu */
#appointment-details table th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2.2px solid #e0bfc2 !important;
    font-size: 1.02rem;
    letter-spacing: .18px;
}
#appointment-details table td {
    background: #fff9fa;
    color: #713339;
    font-size: 0.98rem;
    vertical-align: middle;
}

/* Responsive */
@media (max-width: 900px) {
    .randevu-container { padding: 6px 2px 20px 2px; }
    #appointment-details { padding: 8px; }
}
</style>

<div class="randevu-container">
    <!-- Geri butonu -->
    <a href="index.php?page=dashboard" class="randevu-geri-btn">
        <span class="geri-ikon">&#8592;</span> Geri
    </a>

    <!-- Başlık -->
    <h3 class="randevu-title-center">Randevu Takvimi</h3>

    <!-- Seçilen gün paneli -->
    <div id="appointment-details">
        <h5 class="text-center mb-3">
            Seçilen Gün: <span id="selected-date-text">--</span>
        </h5>
        <table class="table table-bordered mb-2">
            <thead>
                <tr>
                    <th>Hasta</th>
                    <th>Saat</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody id="details-body"></tbody>
        </table>
    </div>

    <!-- Takvim -->
    <div id="calendar"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'tr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        events: 'index.php?page=doctorAppointmentsJson',
        dateClick: function(info) {
            fetchAndShowAppointments(info.dateStr);
        },
        eventClick: function(info) {
            const clickedDate = info.event.startStr;
            fetchAndShowAppointments(clickedDate);
        }
    });

    calendar.render();

    function fetchAndShowAppointments(dateStr) {
        const formatted = new Date(dateStr).toLocaleDateString('tr-TR', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('selected-date-text').textContent = formatted;

        fetch('index.php?page=doctorDayAppointments', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'date=' + dateStr
        })
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('details-body');
            tbody.innerHTML = '';
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" class="text-muted">Randevu bulunamadı.</td></tr>';
            } else {
                data.forEach(item => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${item.patient}</td>
                            <td>${item.time}</td>
                            <td>
                                ${item.status}
                                <a href="index.php?page=doctor-use-material&appointment_id=${item.id}" 
                                class="btn btn-sm btn-outline-primary ms-2"
                                target="_blank" 
                                title='Bu randevuya malzeme ekle'>
                                🧪
                                </a>
                            </td>
                        </tr>`;
                });
            }
            // Detay paneli yukarıda olduğundan her zaman görünür olacak.
            document.getElementById('appointment-details').style.display = 'block';
        });
    }
});
</script>
