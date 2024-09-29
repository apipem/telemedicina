<?php
use app\assets\AppAsset;

/** @var yii\web\View $this */
/** @var string $content */

AppAsset::register($this);

$session = Yii::$app->session;
if ($session->isActive && isset(Yii::$app->user->identity->id)) {
    $this->beginPage();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <?php
        $randomIconUrl = 'https://favicongrabber.com/api/grab/' . urlencode('https://example.com'); // Cambia 'https://example.com' por la URL del sitio del que deseas obtener el favicon
        ?>
        <link rel="icon" type="image/x-icon" href="<?= $randomIconUrl ?>" />

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telemedicina</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/all.min.css') ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/adminlte.min.css') ?>">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->createUrl('css/main.css') ?>">

        <style>
            .bg-image {
                background-image: url('<?= \yii\helpers\Url::to('@web/images/banner-medico-medico-gafas.jpg') ?>');
                background-size: cover;
                background-position: center;
                position: relative;
                min-height: 100vh;
                color: white;
            }

            .bg-image p {
                color: white;
            }

            .bg-image::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1;
            }

            .row {
                position: relative;
                z-index: 2;
            }
        </style>
    </head>

    <body>
        <?php echo $this->render("_sidebar-left") ?>
        <div class="wrapper">
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <?php echo $this->render("_header") ?>
                    </div><!-- /.container-fluid -->
                </div><!-- /.content-header -->

                <?php $this->beginBody(); ?>

                <!-- Main content -->
                <div class="container bg-image">
                    <div class="row">
                        <div class="col">
                            <?php echo $content ?>
                        </div>
                    </div>
                </div>

                <?php $this->endBody(); ?>
            </div><!-- /.content-wrapper -->
        </div><!-- ./wrapper -->

        <?= $this->render("_footer"); ?>

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
            $(document).ready(function() {
                var currentUrl = window.location.pathname;

                $(".nav-link").each(function() {
                    var linkUrl = $(this).attr("href");

                    if (currentUrl === linkUrl || currentUrl.startsWith(linkUrl + '/')) {
                        $(this).addClass("active");
                        $(this).closest(".nav-item").addClass("menu-open");
                    }
                });
            });
        </script>

    </body>
    </html>

    <?php
    $this->endPage();
} else {
    $this->beginPage();
    ?>

    <?php $this->beginBody(); ?>
    <?php echo $this->render("index"); ?>
    <?php $this->endBody(); ?>

    <?php
    $this->endPage();
}
?>
