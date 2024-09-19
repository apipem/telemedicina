<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Videollamadas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="videollamadas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_paciente')->textInput() ?>

    <?= $form->field($model, 'id_medico')->textInput() ?>

    <?= $form->field($model, 'url_reunion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_programada')->textInput() ?>

    <?= $form->field($model, 'hora_inicio')->textInput() ?>

    <?= $form->field($model, 'hora_fin')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'programada' => 'Programada', 'completada' => 'Completada', 'cancelada' => 'Cancelada', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'notas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_creacion')->textInput() ?>

    <?= $form->field($model, 'fecha_actualizacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
