<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Subida de Documentos';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Subida de Documentos</h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Selecciona los documentos a subir</h5>
                </div>
                <div class="card-body">
                    <form id="upload-form" enctype="multipart/form-data" method="post" action="<?= Yii::$app->getUrlManager()->createUrl("subida/upload") ?>">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

                        <div class="form-group">
                            <label for="medico">Selecciona un Médico</label>
                            <select name="ArchivosSubidos[medico]" class="form-control" id="medico">
                                <option value="">Selecciona un Médico</option>
                                <?php foreach ($users as $id => $nombre): ?>
                                    <option value="<?= $id ?>"><?= Html::encode($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ruta_archivo">Archivos</label>
                            <input type="file" name="ArchivosSubidos[ruta_archivo][]" id="ruta_archivo" class="form-control" multiple>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripcion</label>
                            <input type="input" name="ArchivosSubidos[description]" id="description" class="form-control">
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('Subir Archivos', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Archivos Subidos -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Archivos Subidos</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($archivos)): ?>
                        <ul class="list-group">
                            <?php foreach ($archivos as $archivo): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= Html::encode(basename($archivo->ruta_archivo)) ?>
                                    <span class="badge badge-primary"><?= Html::encode($archivo->medico0->nombre_completo) ?></span>
                                    <?= Html::a('Descargar', Yii::getAlias('@web/' . $archivo->ruta_archivo), [
                                        'class' => 'btn btn-secondary btn-sm ml-3',
                                        'target' => '_blank'
                                    ]) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No has subido archivos aún.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    $('#upload-form').on('submit', function(e) {
        e.preventDefault(); // Detener el envío del formulario por defecto
        var form = $(this);
        var medico = form.find('select[name="ArchivosSubidos[medico]"]').val();
        var archivos = form.find('input[name="ArchivosSubidos[ruta_archivo][]"]')[0].files;

        // Validaciones
        if (!medico) {
            Swal.fire({
                title: 'Error!',
                text: 'Por favor, selecciona un médico.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return false; // Detener la ejecución
        }

        if (archivos.length === 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Por favor, selecciona al menos un archivo para subir.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return false; // Detener la ejecución
        }

        // Si las validaciones pasan, se envía el formulario
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-Token': $('input[name="_csrf"]').val() // Include the CSRF token
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Los archivos han sido subidos exitosamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
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

    });
});

</script>
