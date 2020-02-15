<?php

/**********
Versión: 001
Fecha: 12-07-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD PMI
---------------------------------------
**********/

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pmi */

$this->title = 'Modificar PMI: ';
$this->params['breadcrumbs'][] = ['label' => 'PMI', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="pmi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,		'institucion' 	=> $institucion,
		'estados' 		=> $estados,
		'procesos' 		=> $procesos,
		'zonas' 		=> $zonas,
		'comunas' 		=> $comunas,
        'areasGestion'	=> $areasGestion,
        'subProcesoEvaluacion'	=> $subProcesoEvaluacion,
		'subProcesoEvaluacionData'	=> $subProcesoEvaluacionData,
		'procesosData'	=> $procesosData,
    ]) ?>

</div>
