<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResultadosEvaluacionDocente */

$this->title = 'Agregar Resultados Evaluación Docente';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Evaluación Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="resultados-evaluacion-docente-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
		'estados'	=> $estados,
		'institucion'=> $institucion,
    ]) ?>

</div>
