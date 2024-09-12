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
