<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'], // Añadido para estilizar el formulario
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nombre_completo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'documento')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tipo_documento')->dropDownList([
                'TI' => 'TI',
                'CC' => 'CC',
                'CE' => 'CE',
                'OTRO' => 'OTRO',
            ], ['prompt' => 'Seleccionar tipo de documento']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'contrasena')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'correo_electronico')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'rol')->dropDownList([
                'Paciente' => 'Paciente',
                'Medico' => 'Medico',
            ], ['prompt' => 'Seleccionar rol']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
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
            <?= $form->field($model, 'fecha_nacimiento')->input('date') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'genero')->dropDownList([
                'masculino' => 'Masculino',
                'femenino' => 'Femenino',
                'otro' => 'Otro',
            ], ['prompt' => 'Seleccionar género']) ?>
        </div>
        <!--
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_creacion')->input('date') ?>
        </div>
        -->
    </div>
    <!--
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_actualizacion')->input('date') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->textInput() ?>
        </div>
    </div>
    -->

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
