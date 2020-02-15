<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SemillerosTicSemillerosDatosIeo */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Tic Semilleros Datos Ieos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="semilleros-tic-semilleros-datos-ieo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
