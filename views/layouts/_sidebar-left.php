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
                <!-- Materias -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Materias
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Yii::$app->getUrlManager()->createUrl('materia/index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mis Materias</p>
                            </a>
                        </li>
                        <?php if (Yii::$app->user->identity->rol == "profesor"): ?>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->getUrlManager()->createUrl('materia/listado') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Materias</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <!-- Recursos -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Recursos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php if (Yii::$app->user->identity->rol == "profesor"): ?>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->getUrlManager()->createUrl('contenido/create') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Agreagar Material</p>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->getUrlManager()->createUrl('contenido/create') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Subir evidencias</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a href="<?= Yii::$app->getUrlManager()->createUrl('contenido/index') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ver Recursos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Proyectos -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>
                            Proyectos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/proyecto') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mis Proyectos</p>
                            </a>
                        </li>
                        <?php if (Yii::$app->user->identity->rol == "profesor"): ?>
                            <li class="nav-item">
                                <a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/index') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Listar Proyectos</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="<?= Yii::$app->getUrlManager()->createUrl('proyecto/grupos') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Grupos</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Notas -->
                <li class="nav-item">
                    <a href="<?= Yii::$app->getUrlManager()->createUrl('notas/notas') ?>" class="nav-link">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>Notas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
