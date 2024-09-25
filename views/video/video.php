<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (Yii::$app->user->identity->rol == "Medico") { ?>
<div class="container mt-5">
    <div class="mb-4">
        <h3>Programar Videollamada</h3>
        <div class="row">
            <div class="col-md-6">
                <label for="meetLink" class="form-label">Enlace de Google Meet</label>
                <input type="url" class="form-control" id="meetLink" placeholder="https://meet.google.com/..."
                       value="<?= htmlspecialchars($video->url_reunion ?? '') ?>" required>
            </div>
            <div class="col-md-6">
                <label for="fechaHora" class="form-label">Fecha y Hora</label>
                <input type="datetime-local" class="form-control" id="fechaHora"
                       value="<?= $video->fecha_programada ? date('Y-m-d\TH:i', strtotime($video->fecha_programada)) : '' ?>" required>
            </div>
        </div>
        <div class="container text-center mt-4">
            <div class="row">
                <?php if (!empty($video->url_reunion)): ?>
                    <div class="col">
                        <button class="btn btn-success btn-lg" id="joinMeetButton" onclick="window.open('<?= htmlspecialchars($video->url_reunion) ?>', '_blank')">
                            Unirse a la Videollamada
                        </button>
                    </div>
                <?php endif; ?>
                <div class="col">
                    <button class="btn btn-primary btn-lg mb-3" id="scheduleButton">
                        Programar
                    </button>
                </div>
            </div>
        </div>

    </div>

   <form id="consulta-form" class="border p-4 rounded shadow-sm">
       <h2 class="text-center mb-4">Detalles de la Consulta</h2>
       <div class="row mb-3">
           <div class="col-md-6">
               <label for="patientName" class="form-label">Nombre del Paciente</label>
               <input type="text" class="form-control" value="<?= htmlspecialchars($video->paciente->nombre_completo ?? '') ?>" id="patientName" readonly required>
           </div>
           <div class="col-md-6">
               <label for="patientName" class="form-label">Correo</label>
               <input type="text" class="form-control" value="<?= htmlspecialchars($video->paciente->correo_electronico ?? '') ?>" id="patientName"  required>
           </div>
       </div>
       <div class="row mb-3">
           <div class="col-md-6">
               <label for="patientName" class="form-label">Direccion</label>
               <input type="text" class="form-control" value="<?= htmlspecialchars($video->paciente->direccion ?? '') ?>" id="patientName"  required>
           </div>
            <div class="col-md-6">
              <label for="patientName" class="form-label">Celular</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($video->paciente->telefono ?? '') ?>" id="patientName"  required>
          </div>
           <div class="col-md-12">
               <label for="consultaDetails" class="form-label">Detalles de la Consulta</label>
               <textarea class="form-control" id="consultaDetails" rows="4" placeholder="Escriba los detalles de la consulta aquí..." required></textarea>
           </div>
       </div>
       <div class="mb-3">
           <label for="additionalNotes" class="form-label">Notas Adicionales</label>
           <textarea class="form-control" id="additionalNotes" rows="2" placeholder="Notas adicionales (opcional)"></textarea>
       </div>
       <div class="text-center mt-4">
           <button type="submit" class="btn btn-primary btn-lg">Guardar Consulta</button>
       </div>
   </form>
</div>

<script>
    $('#scheduleButton').on('click', function() {
        const meetLink = $('#meetLink').val();
        const fechaHora = $('#fechaHora').val();

        if (!meetLink || !fechaHora) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, completa todos los campos.',
            });
            return;
        }

        $.ajax({
            url: '<?= Yii::$app->getUrlManager()->createUrl("video/programar") ?>',
            method: 'POST',
            data: {
                video: <?= $video->id ?>,
                meetLink: meetLink,
                fechaHora: fechaHora,
                <?= Yii::$app->request->csrfParam ?>: '<?= Yii::$app->request->csrfToken ?>'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Videollamada programada correctamente.',
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ocurrió un error al programar la videollamada.',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Inténtalo más tarde.',
                });
            }
        });
    });

    document.getElementById('consulta-form').addEventListener('submit', function(event) {
        event.preventDefault();

        // Aquí puedes agregar lógica para enviar los datos al servidor usando AJAX

        Swal.fire({
            icon: 'success',
            title: 'Consulta Guardada',
            text: 'Los detalles de la consulta han sido guardados exitosamente.',
            confirmButtonText: 'Aceptar'
        });
    });
</script>

<style>
    .container {

        margin: auto;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<?php } elseif (Yii::$app->user->identity->rol == "Paciente") { ?>
<div class="container mt-5">
    <div class="mb-4">
        <h3>Consulta Programada</h3>
        <p><strong>Nombre del Médico:</strong> <?= $persona->nombre_completo ?></p>
        <p>
            <strong>Fecha de la Videollamada:</strong>
            <?= !empty($video->fecha_programada) ? date('d/m/Y h:i A', strtotime($video->fecha_programada)) : 'Aún no tiene asignación' ?>
        </p>
        <p>
            <strong>Enlace de Google Meet:</strong>
            <?php if (!empty($video->url_reunion)): ?>
                <a href="<?= htmlspecialchars($video->url_reunion) ?>" id="meetLinkDisplay" target="_blank"><?= htmlspecialchars($video->url_reunion) ?></a>
                <div class="text-center mt-2">
                    <button class="btn btn-primary" id="joinMeetButton" onclick="window.open('<?= htmlspecialchars($video->url_reunion) ?>', '_blank')">Unirse a la Videollamada</button>
                </div>
            <?php else: ?>
                <span>Aún no tiene asignación</span>
            <?php endif; ?>
        </p>
    </div>
    <h3>Detalles de la Consulta</h3>
</div>

<script>
    document.getElementById('joinMeetButton').addEventListener('click', () => {
        const meetLink = document.getElementById('meetLinkDisplay').textContent;
        window.open(meetLink, '_blank');
    });
</script>

<?php } ?>
