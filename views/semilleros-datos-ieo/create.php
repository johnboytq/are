<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SemillerosDatosIeo */

$this->title = 'CONFORMACIÓN SEMILLEROS TIC';
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Datos Ieos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="semilleros-datos-ieo-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
		'institucion' 	=> $institucion,
		'sede' 			=> $sede,
		'docentes' 		=> $docentes,
		'controller' 	=> $controller,
    ]) ?>

</div>
