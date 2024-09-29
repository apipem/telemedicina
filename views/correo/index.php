<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Usuarios Disponibles';
?>

<style>
    .table {
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }
    .table th {
        color: black;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-email {
        background-color: #28a745;
        color: white;
    }
    .btn-email:hover {
        background-color: #218838;
    }

</style>

    <p></p>
<div class="container">
    <?php if (Yii::$app->user->identity->rol == "Medico"): ?>
        <h2 class="text-center mb-4">Contacto de pacientes</h2>
    <?php elseif (Yii::$app->user->identity->rol == "Paciente"): ?>
        <h2 class="text-center mb-4">Contacto de Medicos</h2>
    <?php endif; ?>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Número de Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user as $usuario): ?>
                <?php if ($usuario->nombre_completo != "admin"): ?>
                    <tr class="text-muted">
                        <td><?= Html::encode($usuario->nombre_completo) ?></td>
                        <td><?= Html::encode($usuario->telefono) ?></td>
                        <td><?= Html::encode($usuario->correo_electronico) ?></td>
                        <td>
                            <?= Html::a('Enviar Correo', 'mailto:' . Html::encode($usuario->correo_electronico), ['class' => 'btn btn-email']) ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
