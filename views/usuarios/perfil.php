<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = 'Actualizar Usuario: ' . $model->nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>

<div class="usuarios-update container mt-4">

    <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">
        <strong>Instrucciones:</strong> Asegúrate de revisar y actualizar la información.
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<style>
    .text-center {
        margin-bottom: 1.5rem; /* Espacio debajo del título */
    }
    .alert {
        margin-bottom: 1.5rem; /* Espacio debajo de la alerta */
    }
</style>
