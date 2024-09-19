<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Videollamadas $model */

$this->title = 'Create Videollamadas';
$this->params['breadcrumbs'][] = ['label' => 'Videollamadas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videollamadas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
