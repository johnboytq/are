<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberIe */

$this->title = 'Agregar Resultados Pruebas Saber IE';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Pruebas Saber IE', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultados-pruebas-saber-ie-create">

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
