<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosSem */

$this->title = 'Actualizar Resultados Sem';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Sems', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="resultados-sem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados'	=> $estados,
		'institucion'=> $institucion,
		
    ]) ?>

</div>
