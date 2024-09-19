<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MensajesChat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mensajes-chat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_chat')->textInput() ?>

    <?= $form->field($model, 'id_remitente')->textInput() ?>

    <?= $form->field($model, 'mensaje')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'enviado_a')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
