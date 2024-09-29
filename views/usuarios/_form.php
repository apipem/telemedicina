<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form container mt-4">

    <?php $form = ActiveForm::begin(); ?>

    <h4 class="text-center mb-4">Información del Usuario</h4>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nombre_completo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'documento')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tipo_documento')->dropDownList([
                'TI' => 'TI',
                'CC' => 'CC',
                'CE' => 'CE',
                'OTRO' => 'OTRO',
            ], ['prompt' => 'Seleccione tipo']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'correo_electronico')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'Ciudad')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_nacimiento')->textInput(['type' => 'date']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'genero')->dropDownList([
                'masculino' => 'Masculino',
                'femenino' => 'Femenino',
                'otro' => 'Otro',
            ], ['prompt' => 'Seleccione género']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rol')->dropDownList([
                'Paciente' => 'Paciente',
                'Medico' => 'Medico',
            ], ['prompt' => 'Seleccione rol', 'disabled' => true]) ?>
        </div>
    </div>

    <div class="form-group text-center mt-4">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
