<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberCali */

$this->title = 'Modificar Resultados Pruebas Saber Cali:';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Pruebas Saber Calis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="resultados-pruebas-saber-cali-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'institucion' 			=> $institucion,
		'estados' 				=> $estados,
		'asignaturas' 			=> $asignaturas,
		'asignaturasData' 		=> $asignaturasData,
		'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
    ]) ?>

</div>
