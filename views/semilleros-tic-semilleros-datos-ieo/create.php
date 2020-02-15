<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SemillerosTicSemillerosDatosIeo */

$this->title = 'Agregar Semilleros Tic Semilleros Datos Ieo';
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Tic Semilleros Datos Ieos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="semilleros-tic-semilleros-datos-ieo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
