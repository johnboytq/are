<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesAutoevaluacionDocentes */

$this->title = 'Agregar Dimension Opciones Autoevaluacion Docentes';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Autoevaluacion Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="dimension-opciones-autoevaluacion-docentes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
