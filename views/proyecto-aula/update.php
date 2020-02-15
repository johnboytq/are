<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectoAula */

$this->title = 'Modificar Proyecto Aula:';
$this->params['breadcrumbs'][] = ['label' => 'Proyecto Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proyecto-aula-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
		'sede' 			=> $sede,
		'personas' 		=> $personas,
		'jornadas' 		=> $jornadas,
		'paralelos' 	=> $paralelos,
        'estados' 		=> $estados,
    ]) ?>

</div>
