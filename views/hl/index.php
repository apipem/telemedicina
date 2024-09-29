<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Generar Mensajes HL7';
?>
<p></p>
<style>

    .card {
        border: 1px solid #28a745; /* Color verde para el borde */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .message-options {
        display: flex; /* Usar flexbox para el menú horizontal */
        justify-content: space-between;
    }
    .message-options button {
        flex: 1; /* Hacer que todos los botones ocupen el mismo ancho */
        margin-right: 10px; /* Espaciado entre botones */
    }
    .message-options button:last-child {
        margin-right: 0; /* Eliminar margen derecho del último botón */
    }

</style>

<div class="container">
    <h2 class="text-center mb-4">Generar Mensajes HL7</h2>

    <div class="card">
        <div class="card-header text-muted">
            <h5>Seleccionar Paciente</h5>
        </div>
        <div class="card-body">
            <form id="message-form" method="post" action="<?= Url::to(['hl/generate']) ?>">
                <div class="form-group">
                    <select id="patient-select" class="form-control" name="patientId" required>
                        <option value="">Escribe para filtrar y seleccionar un paciente</option>
                        <?php foreach ($patients as $patient): ?>
                            <?php if ($patient->nombre_completo != "admin"): ?>
                                <option value="<?= $patient->id ?>"><?= Html::encode($patient->nombre_completo) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="message-options">
                    <button type="button" class="btn btn-success" id="adt-button">Generar ADT (Admit/Discharge/Transfer)</button>
                    <button type="button" class="btn btn-success" id="orm-button">Generar ORM (Order Entry)</button>
                    <button type="button" class="btn btn-success" id="rsp-button">Generar RSP (Response)</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Acciones de los botones
        $('#adt-button').on('click', function() {
            const patientId = $('#patient-select').val();
            if (patientId) {
                window.open('<?= Url::to(["hl/generate-adm"]) ?>?patientId=' + patientId, '_blank');
            } else {
                alert('Por favor, selecciona un paciente.');
            }
        });

        $('#orm-button').on('click', function() {
            const patientId = $('#patient-select').val();
            if (patientId) {
                const orderDetails = {
                    patient_id: patientId,
                };
                window.open('<?= Url::to(["hl/generate-orm"]) ?>?orderDetails=' + encodeURIComponent(JSON.stringify(orderDetails)), '_blank');
            } else {
                alert('Por favor, selecciona un paciente.');
            }
        });

        $('#rsp-button').on('click', function() {
            const patientId = $('#patient-select').val();
            if (patientId) {
                window.open('<?= Url::to(["hl/generate-rsp"]) ?>?patientId=' + patientId, '_blank');
            } else {
                alert('Por favor, selecciona un paciente.');
            }
        });
    });
</script>
