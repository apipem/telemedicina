<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Videollamadas $model */

$this->title = 'Update Videollamadas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Videollamadas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="videollamadas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
