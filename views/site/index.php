<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

 <?php
 $session = Yii::$app->session;
 if ($session->isActive && !Yii::$app->user->isGuest) {
 if (Yii::$app->user->identity->documento == '100' && Yii::$app->user->identity->nombre_completo == 'admin') { ?>
    <style>
        .container {
            margin-top: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <div class="container">
        <h1 class="text-center mb-4">Administración de Usuarios</h1>

        <div class="row">
            <!-- Contenedor de Usuarios a Activar -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Usuarios a Activar</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">

                            <?php foreach ($usersa as $user) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $user->nombre_completo ?> - <?= $user->rol ?>
                                 <button class="btn btn-custom btn-sm activate-user" data-id="<?= $user->id ?>">Activar</button>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contenedor de Usuarios Desactivados -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Usuarios Desactivados</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($userso as $user) { ?>
                                <?php if ($user->nombre_completo != "admin") { ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= $user->nombre_completo ?> - <?= $user->rol ?>
                                     <button class="btn btn-custom-danger btn-sm deactivate-user" data-id="<?= $user->id ?>">Desactivar</button>
                                </li>
                            <?php }} ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
    // Activar usuario
    $('.activate-user').click(function() {
        var userId = $(this).data('id');
        $.ajax({
            url: 'recurso/activate', // Cambia esto por la URL correcta
            type: 'POST',
            data: { id: userId, <?= Yii::$app->request->csrfParam ?>: '<?= Yii::$app->request->csrfToken ?>' },
            success: function(response) {
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Usuario activado con éxito.',
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
                    text: 'Error al activar el usuario: ' + error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });

    // Desactivar usuario
    $('.deactivate-user').click(function() {
        var userId = $(this).data('id');
        $.ajax({
            url: 'recurso/deactivate', // Cambia esto por la URL correcta
            type: 'POST',
            data: { id: userId , <?= Yii::$app->request->csrfParam ?>: '<?= Yii::$app->request->csrfToken ?>'},
            success: function(response) {
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Usuario desactivado con éxito.',
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
                    text: 'Error al desactivar el usuario: ' + error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});
</script>

<?php } ?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <?php
        $session = Yii::$app->session;
        if ($session->isActive && !Yii::$app->user->isGuest): ?>
            <h1 class="display-4 ">Bienvenido, <?= Html::encode(Yii::$app->user->identity->nombre_completo) ?>!</h1>
            <p class="lead mt-3">
                Bienvenido a nuestra plataforma de telemedicina, un entorno diseñado para proporcionar atención médica de alta calidad mediante tecnologías avanzadas de consulta remota. Acceda de manera eficiente, segura y confidencial a profesionales de la salud, optimizando su bienestar en todo momento.
            </p>
        <?php else: ?>
            <h1 class="display-4 text-warning">Acceso Denegado</h1>
            <p class="lead mt-3 text-muted">
                Por favor, inicie sesión para acceder a nuestras funcionalidades de telemedicina.
            </p>
            <a href="<?= Yii::$app->getUrlManager()->createUrl('site/login') ?>" class="btn btn-primary btn-lg mt-4">Iniciar sesión</a>
        <?php endif; ?>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted">¿Cómo Funciona?</h5>
                    <p class="card-text text-muted">
                        Nuestra plataforma le permite conectar con médicos a través de consultas virtuales. Simplemente inicie sesión, seleccione un profesional y programe su cita en línea.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8 text-center">
            <h5 class="mt-4">Beneficios de Usar Nuestra Plataforma:</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">👩‍⚕️ Atención médica accesible desde cualquier lugar.</li>
                <li class="list-group-item">🔒 Seguridad y confidencialidad garantizadas.</li>
                <li class="list-group-item">⏱️ Programación flexible de citas.</li>
                <li class="list-group-item">💬 Consultas en tiempo real con especialistas.</li>
            </ul>
        </div>
    </div>
</div>


<?php } ?>