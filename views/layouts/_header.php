<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="btn btn-secondary" onclick="history.back()">Volver</button>
        <div class="mx-auto text-center" style="flex-grow: 1;">
            <a class="navbar-brand" href="#">Telemedicina</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('') ?>'">
            <i class="nav-icon fas fa-home"></i>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('video/index') ?>'">
            <i class="nav-icon fas fa-video"></i>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('chat/index') ?>'">
            <i class="nav-icon fas fa-comments"></i>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('subida/index') ?>'">
            <i class="nav-icon fas fa-upload"></i>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('correo/index') ?>'">
            <i class="nav-icon fas fa-envelope"></i>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('usuarios/perfil') ?>'">
            <i class="nav-icon fas fa-user"></i>
        </button>

        <?php if (Yii::$app->user->identity->rol == "Medico") { ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                    onclick="window.location.href='<?= Yii::$app->getUrlManager()->createUrl('hl/index') ?>'">
                <i class="nav-icon fas fa-cogs"></i>
            </button>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="nav-icon fas fa-user-check"></i>
                <span id="availability-status" class="<?= Yii::$app->user->identity->status == 1 ? 'text-success' : (Yii::$app->user->identity->status == 0 ? 'text-danger' : 'text-warning') ?>">
                    <?= Yii::$app->user->identity->status == 1 ? 'Disponible' : (Yii::$app->user->identity->status == 0 ? 'No Disponible' : 'En Pausa') ?>
                </span>
            </button>
        <?php } ?>

        <form action="<?= Yii::$app->getUrlManager()->createUrl('logout') ?>" method="get">
            <button class="btn btn-logout" type="submit">
                <i class="nav-icon fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</nav>
