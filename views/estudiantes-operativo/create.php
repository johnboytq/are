<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EstudiantesOperativo */

$this->title = 'Estudiantes Operativo';
// $this->params['breadcrumbs'][] = ['label' => 'Estudiantes Operativos', 'url' => ['index']];
// $this->params['breadcrumbs'][] = "Agregar";
?>
<div class="estudiantes-operativo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'instituciones' => $instituciones,
		'sedes' 		=> $sedes,
		'docentes'		=> $docentes,
		'niveles'		=> $niveles,
		'estados'		=> 1,
    ]) ?>

</div>
