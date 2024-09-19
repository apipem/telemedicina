<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="btn btn-secondary" onclick="history.back()">Volver</button>

        <div class="mx-auto text-center" style="flex-grow: 1;">
            <a class="navbar-brand" style="text-align: center;" href="#">Telemedicina</a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form action="<?= Yii::$app->getUrlManager()->createUrl('logout') ?>" method="get">
                        <button class="btn btn-logout" type="submit">Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
