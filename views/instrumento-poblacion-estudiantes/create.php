<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InstrumentoPoblacionEstudiantes */

$this->title = 'Instrumento Población Estudiantes';
// $this->params['breadcrumbs'][] = ['label' => 'Instrumento Población Estudiantes', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="instrumento-poblacion-estudiantes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'instituciones' => $instituciones,
		'sedes' 		=> $sedes,
		'estudiantes'	=> $estudiantes,
		'estados'		=> $estados,
    ]) ?>

</div>
