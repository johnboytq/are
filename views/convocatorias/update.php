<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Convocatorias */

$this->title = 'Modificar Convocatoria:';
$this->params['breadcrumbs'][] = ['label' => 'Convocatorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="convocatorias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'sede' 		=> $sede,
		'estados' 	=> $estados,
    ]) ?>

</div>
