<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subida de Documentos';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Subida de Documentos</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Selecciona los documentos a subir</h5>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data', 'id' => 'upload-form'],
                    ]); ?>

                    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true])->label('Archivos') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Subir Archivos', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    $('#upload-form').on('beforeSubmit', function(e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Los archivos han sido subidos exitosamente.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Recargar la página
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No se pudo subir los archivos: ' + error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
        return false; // Evitar que el formulario se envíe de forma tradicional
    });
});
</script>
