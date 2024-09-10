<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Iniciar Sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Proyecto Integrador</h1>

                <p class="card-text text-center">Por favor, ingrese su número de documento y su contraseña:</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'fieldConfig' => [
                        'template' => "{label}\n<div class='col-lg-6'>{input}</div>\n<div class='col-lg-6'>{error}</div>",
                        'labelOptions' => ['class' => 'col-lg-6 col-form-label'],
                        'inputOptions' => ['class' => 'form-control', 'style' => 'border-color: #6c757d;'], // Color del contorno (gris)
                        'errorOptions' => ['class' => 'invalid-feedback'],
                    ],
                ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Número de documento']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña']) ?>


                <div class="form-group row">
                    <div class="offset-lg-12 col-lg-6">
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                    <div class="offset-lg-0 col-lg-6">
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Registrar</button>
                            <?= Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-primary', 'name' => 'login-button', 'style' => 'background-color: #6c757d; border-color: #6c757d;']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Capturar el mensaje de "No autorizado" y mostrar una alerta
    $(document).ready(function() {
        if ($('h2:contains("No autorizado")').length > 0) {
            alert("No autorizado");
        }
    });
</script>
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= Yii::$app->getUrlManager()->createUrl('js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= Yii::$app->getUrlManager()->createUrl('js/adminlte.min.js') ?>"></script>
<!-- Custom Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Importar Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>

    function enviar() {
        $.ajax({
            method: "get",
            url: "<?= Yii::$app->getUrlManager()->createUrl('recurso/persona') ?>",
            data: {
                cc: $("#cc").val(),
                name: $("#name").val(),
                last: $("#last").val(),
                user: $("#user").val(),
                email: $("#email").val(),
                password: $("#password").val(),
            },
            success: function(json) {
                if (json == "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Inscrito!',
                        text: 'Registro completo!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    })
                } else {
                    Swal.fire(
                        'Oh no!',
                        'Algo salió mal!',
                        'error'
                    )
                }
            },
        });
    }
</script>
