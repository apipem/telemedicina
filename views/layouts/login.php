<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\LoginAsset;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="es"> <!--<![endif]-->
<!-- START @HEAD -->
<head>
    <!-- START @META SECTION -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Bootstrap CSS -->
    <!-- Importar Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= Yii::$app->name." - ".$this->title ?></title>
    <!--/ END META SECTION -->

    <!-- START @FONT STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Oswald:700,400" rel="stylesheet">
    <!--/ END FONT STYLES -->
    <?php  $this->head();  ?>
    <style>
        /* Estilo para el cuerpo */
        body{
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-image: url('https://aplicativos.udi.edu.co/investigaciones/img/invest2.jpg');
        }
    </style>
</head>
<!--/ END HEAD -->
<body class="page-sound yii2">
<?php $this->beginBody() ?>
<!--[if lt IE 9]>
<p class="upgrade-browser">Upps!! You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- START @SIGN WRAPPER -->
<?php echo $content ?>
<!--/ END SIGN WRAPPER -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registrationForm" action="/academy/web/persona/psico" method="post">
                    <div class="row">
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="cc" class="col-form-label">Documento:</label>
                                <input type="number" name="cc" id="cc" class="form-control">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Nombres:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="last" class="col-form-label">Apellidos:</label>
                                <input type="text" class="form-control" id="last" name="last">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="user" class="col-form-label">Usuario:</label>
                                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="user" id="user">
                                    <option selected>Selecciona</option>
                                    <option value="estudiante">Estudiante</option>
                                    <option value="profesor">Profesor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="email" class="col-form-label">Correo:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="mb-3">
                                <label for="password" class="col-form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="enviar()" class="btn btn-secondary">Registrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
<!-- END BODY -->
</html>
<?php $this->endPage() ;?>