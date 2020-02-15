<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberCali */

$this->title = 'Agregar Resultados Pruebas Saber Cali';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Pruebas Saber Cali', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultados-pruebas-saber-cali-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 				=> $model,
		'institucion' 			=> $institucion,
		'estados' 				=> $estados,
		'asignaturas' 			=> $asignaturas,
		'asignaturasData' 		=> $asignaturasData,
		'asignaturasEvaluadas' 	=> $asignaturasEvaluadas,
    ]) ?>

</div>
