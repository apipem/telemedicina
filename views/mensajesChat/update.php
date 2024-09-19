<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MensajesChat $model */

$this->title = 'Update Mensajes Chat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mensajes-chat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
