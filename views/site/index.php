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
        if ($session->isActive && !Yii::$app->user->isGuest) {
            ?>
            <h1>Bienvenido <?= Yii::$app->user->identity->rol ?></h1>
        <?php } ?>

    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/video-llamada') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-video"></i> Video Llamada
            </a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/chat-en-linea') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-comments"></i> Chat en Línea
            </a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/subir-archivos') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-upload"></i> Subir Archivos
            </a>
        </div>

    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/correo-electronico') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-envelope"></i> Correo Electrónico
            </a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/perfil-usuario') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-user"></i> Perfil del Usuario
            </a>
        </div>
        <!--
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/configuracion') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-cogs"></i> Configuración
            </a>
        </div>
        -->
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('site/logout') ?>" class="btn btn-secondary btn-lg btn-block">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>
</div>
<?php } ?>