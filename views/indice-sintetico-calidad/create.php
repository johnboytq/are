<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IndiceSinteticoCalidad */

$this->title = 'Agregar Indice Sintético de Calidad';
$this->params['breadcrumbs'][] = ['label' => 'Indice Sintético de Calidad', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indice-sintetico-calidad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados' 			=> $estados,
		'indicesEspecificos'=> $indicesEspecificos,
    ]) ?>

</div>
