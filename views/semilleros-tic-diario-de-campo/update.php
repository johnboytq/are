<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SemillerosTicDiarioDeCampo */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Tic Diario De Campos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="semilleros-tic-diario-de-campo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fases' => $fases,
        'fasesModel' => $fasesModel,
    ]) ?>

</div>
