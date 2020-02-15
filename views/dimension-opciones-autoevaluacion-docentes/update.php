<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesAutoevaluacionDocentes */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Autoevaluacion Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="dimension-opciones-autoevaluacion-docentes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
