<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SedesCobertura */

$this->title = 'Update Sedes Cobertura: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sedes Coberturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sedes-cobertura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
