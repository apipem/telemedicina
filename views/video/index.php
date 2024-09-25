<style>
    .card {
        cursor: pointer;
        transition: transform 0.2s;
        border: 2px solid transparent;
    }
    .card:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }
    .card.selected {
        border-color: #007bff;
        background-color: #e7f1ff;
    }
    .disponible {
        background-color: #d4edda; /* Verde claro */
        border-color: #c3e6cb; /* Verde más oscuro */
    }
    .no_disponible {
        background-color: #f8d7da; /* Rojo claro */
        border-color: #f5c6cb; /* Rojo más oscuro */
    }
    .en_pausa {
        background-color: #fff3cd; /* Amarillo claro */
        border-color: #ffeeba; /* Amarillo más oscuro */
    }
</style>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <?php if (Yii::$app->user->identity->rol == "Paciente") { ?>
        <h2>Seleccionar un Médico para Video llamada</h2>
        <div class="row">
            <?php foreach ($medicos as $medico) { ?>
                <?php if ($medico->status != "0") { ?>
                    <div class="col-md-4">
                        <div class="card mb-4 <?= $medico->status == "1" ? '' : ($medico->status == "2" ? 'en_pausa' : ''); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($medico->nombre_completo) ?></h5>
                                <p class="card-text">Médico General</p>
                                <a href="video?video=<?= urlencode(Yii::$app->security->encryptByKey($medico->id, 'telem')) ?>&action=crear" class="btn btn-primary">Solicitar</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (Yii::$app->user->identity->rol == "Medico") { ?>
        <h2>Seleccionar Estado de Disponibilidad</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 disponible" onclick="selectStatus(this, '1')">
                    <div class="card-body text-center">
                        <h5 class="card-title">Disponible</h5>
                        <p class="card-text">Estás disponible para atender consultas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 no_disponible" onclick="selectStatus(this, '0')">
                    <div class="card-body text-center">
                        <h5 class="card-title">No Disponible</h5>
                        <p class="card-text">No estás disponible para atender consultas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4 en_pausa" onclick="selectStatus(this, '2')">
                    <div class="card-body text-center">
                        <h5 class="card-title">En Pausa</h5>
                        <p class="card-text">Estás en pausa, puedes volver más tarde.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-primary" id="confirm-button" disabled>Confirmar Estado</button>
        </div>
    <?php } ?>

    <h2>Videollamadas Programadas</h2>
    <div class="row">
        <?php foreach ($video as $videollamada) { ?>
            <?php if ($videollamada->estado == "programada") { ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(Yii::$app->user->identity->rol == "Medico" ? $videollamada->paciente->nombre_completo : $videollamada->medico->nombre_completo) ?></h5>
                            <p class="card-text">Fecha Programada:<?= !empty($videollamada->fecha_programada)? date('d/m/Y h:i A', strtotime($videollamada->fecha_programada)): 'Aún no tiene asignación'?></p>
                            <a href="video?video=<?= urlencode(Yii::$app->security->encryptByKey(Yii::$app->user->identity->rol == "Medico" ? $videollamada->id_paciente : $videollamada->id_medico, 'telem')) ?>&action=consultar&chatId=<?= urlencode($videollamada->id) ?>" class="btn btn-primary">Ingresar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <h2>Videollamadas Cerradas</h2>
    <div class="row">
        <?php foreach ($videoe as $videollamada) { ?>
            <?php if ($videollamada->estado == "completada") { ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars(Yii::$app->user->identity->rol == "Medico" ? $videollamada->paciente->nombre_completo : $videollamada->medico->nombre_completo) ?></h5>
                            <p class="card-text">Fecha Programada: <?= date('d/m/Y h:i A', strtotime($videollamada->fecha_programada)) ?></p>
                            <a href="video?video=<?= urlencode(Yii::$app->security->encryptByKey(Yii::$app->user->identity->rol == "Medico" ? $videollamada->id_paciente : $videollamada->id_medico, 'telem')) ?>&action=consultar&chatId=<?= urlencode($videollamada->id) ?>" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<script>
    let selectedStatus = null;

    function selectStatus(cardElement, status) {
        document.querySelectorAll('.card').forEach(card => card.classList.remove('selected'));
        cardElement.classList.add('selected');
        selectedStatus = status;
        document.getElementById('confirm-button').disabled = false;
    }

    document.getElementById('confirm-button').addEventListener('click', () => {
        $.ajax({
            url: '<?= Yii::$app->getUrlManager()->createUrl("recurso/estado") ?>',
            method: 'POST',
            data: {
                disponibilidad: selectedStatus,
                <?= Yii::$app->request->csrfParam ?>: '<?= Yii::$app->request->csrfToken ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error al cambiar el estado. Inténtalo de nuevo.');
                }
            },
            error: function() {
                alert('Error de conexión. Inténtalo más tarde.');
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
