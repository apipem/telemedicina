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
            <a href="<?= Yii::$app->getUrlManager()->createUrl('materia/index') ?>" class="btn btn-secondary btn-lg btn-block">Materias</a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('contenido/index') ?>" class="btn btn-secondary btn-lg btn-block">Recursos</a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/proyecto') ?>" class="btn btn-secondary btn-lg btn-block">Proyectos</a>
        </div>
        <div class="col-3">
            <a href="<?= Yii::$app->getUrlManager()->createUrl('notas/notas') ?>" class="btn btn-secondary btn-lg btn-block">Notas</a>
        </div>
    </div>
</div>
