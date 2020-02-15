<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProyectoAula */

$this->title = 'Agregar Proyecto de Aula';
$this->params['breadcrumbs'][] = ['label' => 'Proyecto Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyecto-aula-create">

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
