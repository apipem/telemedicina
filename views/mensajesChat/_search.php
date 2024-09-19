<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MensajesChatSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mensajes-chat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_chat') ?>

    <?= $form->field($model, 'id_remitente') ?>

    <?= $form->field($model, 'mensaje') ?>

    <?= $form->field($model, 'enviado_a') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
