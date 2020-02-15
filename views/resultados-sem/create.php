<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ResultadosSem */

$this->title = 'Agregar Resultados Sem';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Sems', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Agregar';
?>
<div class="resultados-sem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados'	=> $estados,
		'institucion'=> $institucion,
    ]) ?>

</div>
