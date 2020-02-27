<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AulasXParalelos */

$this->title = 'Modificar: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aulas Xparalelos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aulas-xparalelos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'model' 			=> $model,
			'grupos' 			=> $grupos,
			'aulas' 			=> $aulas,
			'niveles' 			=> $niveles,
			'paralelosSearch' 	=> $paralelosSearch,
			'nivelesSearch' 	=> $nivelesSearch,
			'jornadas' 			=> $jornadas,
        ]) ?>

</div>
