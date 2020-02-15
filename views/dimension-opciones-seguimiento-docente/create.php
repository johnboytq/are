<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesSeguimientoDocente */

$this->title = 'Agregar Dimension Opciones Seguimiento Docente';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Seguimiento Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="dimension-opciones-seguimiento-docente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
