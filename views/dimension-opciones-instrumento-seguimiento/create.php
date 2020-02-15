<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesInstrumentoSeguimiento */

$this->title = 'Agregar Dimension Opciones Instrumento Seguimiento';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Instrumento Seguimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="dimension-opciones-instrumento-seguimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
