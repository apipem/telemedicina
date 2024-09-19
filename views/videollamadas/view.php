<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Videollamadas $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Videollamadas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="videollamadas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_paciente',
            'id_medico',
            'url_reunion:url',
            'fecha_programada',
            'hora_inicio',
            'hora_fin',
            'estado',
            'notas:ntext',
            'fecha_creacion',
            'fecha_actualizacion',
        ],
    ]) ?>

</div>
