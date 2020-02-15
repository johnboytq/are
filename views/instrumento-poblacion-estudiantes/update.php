<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstrumentoPoblacionEstudiantes */

$this->title = 'Update Instrumento Poblacion Estudiantes: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Instrumento Poblacion Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instrumento-poblacion-estudiantes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'instituciones' => $instituciones,
		'sedes' 		=> $sedes,
		'estudiantes'	=> $estudiantes,
		'estados'		=> $estados,
    ]) ?>

</div>
