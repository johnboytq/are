<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberIe */

$this->title = 'Modificar Resultados Pruebas del Saber IE: ';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Pruebas del Saber IE', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="resultados-pruebas-saber-ie-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('//resultados-pruebas-saber-cali/_form', [
        'model' => $model,
		'institucion' 			=> $institucion,
		'estados' 				=> $estados,
		'asignaturas' 			=> $asignaturas,
		'asignaturasData' 		=> $asignaturasData,
		'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
    ]) ?>

</div>
