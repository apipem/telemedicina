<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message string */

$this->title = 'Mensaje HL7';
?>
<div class="container mt-5">
    <h2 class="text-center mb-4"><?= Html::encode($this->title) ?></h2>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Contenido del Mensaje</h5>
        </div>
        <div class="card-body">
            <pre style="white-space: pre-wrap; word-wrap: break-word;"><?= Html::encode($message) ?></pre>
        </div>
        <div class="card-footer text-center">
            <a href="#" class="btn btn-success" onclick="downloadHL7()">Descargar Mensaje</a>
            <a href="<?= Yii::$app->request->referrer ?>" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>

<script>
function downloadHL7() {
    const blob = new Blob([<?= json_encode($message) ?>], { type: 'text/plain' });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'mensaje_hl7.txt';
    link.click();
}
</script>

<style>
    .card {
        border: 1px solid #28a745; /* Borde verde */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #f8f9fa; /* Color de fondo claro */
    }
    .btn {
        margin: 5px; /* Espaciado entre botones */
    }
</style>
