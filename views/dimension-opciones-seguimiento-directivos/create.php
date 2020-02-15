<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DimensionOpcionesSeguimientoDirectivos */

$this->title = 'Agregar Dimension Opciones Seguimiento Directivos';
$this->params['breadcrumbs'][] = ['label' => 'Dimension Opciones Seguimiento Directivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="dimension-opciones-seguimiento-directivos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
