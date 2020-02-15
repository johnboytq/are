<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\IndiceSinteticoCalidad */

$this->title = 'Modificar Indice Sintético de Calidad: ';
$this->params['breadcrumbs'][] = ['label' => 'Indice Sintético Calidad', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="indice-sintetico-calidad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados' 			=> $estados,
		'indicesEspecificos'=> $indicesEspecificos,
    ]) ?>

</div>
