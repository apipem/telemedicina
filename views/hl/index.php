<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Generar Mensajes HL7';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <div class="card-body text-muted">
            <form id="message-form" method="post" action="">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
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
                <div class="form-group">
                    <label for="order-id">ID de Orden:</label>
                    <input type="text" id="order-id" class="form-control" name="orderId" required>
                </div>
                <div class="form-group">
                    <label for="doctor-name">Nombre del Doctor:</label>
                    <input type="text" id="doctor-name" class="form-control" value="<?= Html::encode(Yii::$app->user->identity->nombre_completo) ?>" name="doctorName" readonly required>
                </div>
                <div class="form-group">
                    <label for="test-name">Nombre de la Prueba:</label>
                    <input type="text" id="test-name" class="form-control" name="testName" required>
                </div>
                <div class="message-options">
                    <button type="submit" class="btn btn-success" id="adt-button">Generar ADT (Admit/Discharge/Transfer)</button>
                    <button type="submit" class="btn btn-success" id="orm-button">Generar ORM (Order Entry)</button>
                    <button type="submit" class="btn btn-success" id="rsp-button">Generar RSP (Response)</button>
                </div>
                <input type="hidden" name="action" id="form-action" value="">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Manejar el envío del formulario
        $('#adt-button').on('click', function() {
            $('#form-action').val('adt');
            $('#message-form').attr('action', '<?= Url::to(["hl/generate-adm"]) ?>');
        });

        $('#orm-button').on('click', function() {
            $('#form-action').val('orm');
            $('#message-form').attr('action', '<?= Url::to(["hl/generate-orm"]) ?>');
        });

        $('#rsp-button').on('click', function() {
            $('#form-action').val('rsp');
            $('#message-form').attr('action', '<?= Url::to(["hl/generate-rsp"]) ?>');
        });

        $('#message-form').on('submit', function(e) {
            const patientId = $('#patient-select').val();
            const orderId = $('#order-id').val();
            const testName = $('#test-name').val();

            if (!patientId || (this.action.includes("generate-orm") && (!orderId || !testName))) {
                e.preventDefault(); // Previene el envío del formulario si no hay datos completos
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, completa todos los campos requeridos.',
                });
            }
        });
    });
</script>
