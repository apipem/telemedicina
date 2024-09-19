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

<?php if (Yii::$app->user->identity->rol == "Paciente") { ?>
<div class="container mt-5">
    <h2>Seleccionar un Médico para Chatear</h2>
    <div class="row">
        <?php foreach ($medicos as $medico) { ?>
        <?php if ($medico->disponible != "0") { ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <?php if ($medico->disponible == "1") { ?>
                    <div class="card-body ">
                <?php }?>
                <?php if ($medico->disponible == "2") { ?>
                    <div class="card-body en_pausa">
                <?php }?>
                    <h5 class="card-title"><?= $medico->nombre_completo ?></h5>
                    <p class="card-text">Médico General</p>
                    <a href="chat?chat=<?= urlencode(Yii::$app->security->encryptByKey($medico->id, 'telem')) ?>" class="btn btn-primary">Chatear</a>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>
<?php } ?>

<?php if (Yii::$app->user->identity->rol == "Medico") { ?>
<div class="container mt-5">
    <h2>Seleccionar su Estado de Disponibilidad</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 disponible" onclick="selectStatus(this, 'disponible')">
                <div class="card-body text-center">
                    <h5 class="card-title">Disponible</h5>
                    <p class="card-text">Estás disponible para atender consultas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 no_disponible" onclick="selectStatus(this, 'no_disponible')">
                <div class="card-body text-center">
                    <h5 class="card-title">No Disponible</h5>
                    <p class="card-text">No estás disponible para atender consultas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 en_pausa" onclick="selectStatus(this, 'en_pausa')">
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
</div>
<?php } ?>

<div class="container mt-5">
    <h2>Conversaciones Abiertas</h2>
    <div class="row">
        <?php foreach ($chats as $chat) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php if (Yii::$app->user->identity->rol == "Medico") { ?>
                            <h5 class="card-title"><?= htmlspecialchars($chat->paciente->nombre_completo ?? 'Desconocido') ?></h5>
                        <?php } elseif (Yii::$app->user->identity->rol == "Paciente") { ?>
                            <h5 class="card-title"><?= htmlspecialchars($chat->medico->nombre_completo ?? 'Desconocido') ?></h5>
                        <?php } ?>
                        <p class="card-text">Fecha Inicial: <?= date('d \d\e F \d\e Y', strtotime($chat->fecha_inicio)) ?></p>
                        <?php if (Yii::$app->user->identity->rol == "Medico") { ?>
                            <a href="chat?chat=<?= urlencode(Yii::$app->security->encryptByKey($chat->id_paciente, 'telem')) ?>" class="btn btn-primary">Reanudar Chat</a>
                        <?php } elseif (Yii::$app->user->identity->rol == "Paciente") { ?>
                            <a href="chat?chat=<?= urlencode(Yii::$app->security->encryptByKey($chat->id_medico, 'telem')) ?>" class="btn btn-primary">Reanudar Chat</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="container mt-5">
    <h2>Conversaciones Cerradas</h2>
    <div class="row">
        <?php foreach ($chatce as $chat) { ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <?php if (Yii::$app->user->identity->rol == "Medico") { ?>
                            <h5 class="card-title"><?= htmlspecialchars($chat->paciente->nombre_completo ?? 'Desconocido') ?></h5>
                        <?php } elseif (Yii::$app->user->identity->rol == "Paciente") { ?>
                            <h5 class="card-title"><?= htmlspecialchars($chat->medico->nombre_completo ?? 'Desconocido') ?></h5>
                        <?php } ?>
                        <p class="card-text">Fecha Inicial: <?= date('d \d\e F \d\e Y', strtotime($chat->fecha_inicio)) ?></p>
                        <p class="card-text">Fecha Final: <?= date('d \d\e F \d\e Y', strtotime($chat->fecha_fin)) ?></p>
                        <button class="btn btn-primary">Revisar Chat</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    let selectedStatus = null;

    function selectStatus(cardElement, status) {
        // Remover selección de otras tarjetas
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.classList.remove('selected');
        });

        // Marcar la tarjeta seleccionada
        cardElement.classList.add('selected');

        selectedStatus = status;
        document.getElementById('confirm-button').disabled = false; // Habilitar el botón de confirmación
    }

    document.getElementById('confirm-button').addEventListener('click', () => {
        alert(`Estado seleccionado: ${selectedStatus}`);
        // Aquí puedes agregar la lógica para enviar el estado al servidor
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
