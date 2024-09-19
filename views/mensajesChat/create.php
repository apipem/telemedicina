<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MensajesChat $model */

$this->title = 'Create Mensajes Chat';
$this->params['breadcrumbs'][] = ['label' => 'Mensajes Chats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensajes-chat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
