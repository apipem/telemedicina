<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= Yii::$app->getUrlManager()->createUrl('') ?>" class="brand-link" style="text-decoration: none;">
        <img src="<?= Yii::$app->getUrlManager()->createUrl('img/AdminLTELogo.png') ?>" alt="ACADEMY Logo" class="brand-image elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light ms-2">Telemedicina</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="https://picsum.photos/200/200?random" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white"><?= Yii::$app->user->identity->nombre_completo?></a>
                <span class="text-sm text-white"><?= Yii::$app->user->identity->rol?></span>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <form class="form-inline" action="<?= Yii::$app->getUrlManager()->createUrl('notas/filtro') ?>" method="get">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Buscar" name="search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar" type="submit">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- INICIO -->
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('') ?>" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>INICIO</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('video/index') ?>" class="nav-link">
                        <i class="nav-icon fas fa-video"></i>
                        <p>Video Llamada</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('chat/index') ?>" class="nav-link">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Chat en Línea</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/subir-archivos') ?>" class="nav-link">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>Subir Archivos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/correo-electronico') ?>" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Correo Electrónico</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('usuarios/perfil') ?>" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Perfil del Usuario</p>
                    </a>
                </li>

                <!--
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('opciones/configuracion') ?>" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Configuración</p>
                    </a>
                </li>
                -->
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('site/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Cerrar Sesión</p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
