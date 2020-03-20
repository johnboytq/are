<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProyectosPedagogicosTransversales */

$this->title = 'Agregar Proyecto Pedagogico Transversal';
$this->params['breadcrumbs'][] = ['label' => 'Proyectos Pedagogicos Transversales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyectos-pedagogicos-transversales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
        'sede'  	=> $sede,
        'personas'  => $personas,
        'estados'   => $estados,
        'areas'  	=> $areas,
    ]) ?>

</div>
