<?php if (Yii::$app->user->identity->rol == "Medico") { ?>
<div class="container mt-5">
    <!-- Preconsulta -->
    <div class="mb-4">
        <h3>Preconsulta</h3>
        <div class="mb-3">
            <label for="meetLink" class="form-label">Enlace de Google Meet</label>
            <input type="url" class="form-control" id="meetLink" placeholder="https://meet.google.com/..." required>
        </div>
    </div>

</div>
<div class="container mt-5">

    <h2>Detalles de la Consulta</h2>

    <form id="consulta-form">
        <div class="mb-3">
            <label for="patientName" class="form-label">Nombre del Paciente</label>
            <input type="text" class="form-control" id="patientName" required>
        </div>
        <div class="mb-3">
            <label for="consultaDetails" class="form-label">Detalles de la Consulta</label>
            <textarea class="form-control" id="consultaDetails" rows="4" required></textarea>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Guardar Consulta</button>
        </div>
    </form>
</div>

<?php } elseif (Yii::$app->user->identity->rol == "Paciente") { ?>
<div class="container mt-5">
    <button class="btn btn-secondary mb-3" onclick="history.back()">Volver</button>

    <h2>Detalles de la Consulta</h2>

    <div class="mb-4">
        <h3>Consulta Programada</h3>
        <p><strong>Nombre del Médico:</strong> Dr. John Doe</p>
        <p><strong>Fecha de la Videollamada:</strong> 2024-09-18</p>
        <p><strong>Enlace de Google Meet:</strong> <a href="#" id="meetLinkDisplay">https://meet.google.com/xyz</a></p>
        <div class="text-center mt-4">
            <button class="btn btn-primary" id="joinMeetButton">Unirse a la Videollamada</button>
        </div>
    </div>
</div>

<script>
    // Manejo del botón para unirse a la videollamada
    document.getElementById('joinMeetButton').addEventListener('click', () => {
        const meetLink = document.getElementById('meetLinkDisplay').textContent;
        window.open(meetLink, '_blank');
    });

    // Lógica para guardar la consulta en el formulario del médico
    document.getElementById('consulta-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const patientName = document.getElementById('patientName').value;
        const consultaDetails = document.getElementById('consultaDetails').value;
        alert(`Consulta guardada para: ${patientName}\nDetalles: ${consultaDetails}`);
        // Lógica para enviar los datos al servidor
    });
</script>
<?php } ?>
