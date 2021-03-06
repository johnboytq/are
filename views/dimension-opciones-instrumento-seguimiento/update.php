<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesInstrumentoSeguimiento */

$this->title = 'Actualizar';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Instrumento Seguimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Actualizar";
?>
<div class="dimension-opciones-instrumento-seguimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
