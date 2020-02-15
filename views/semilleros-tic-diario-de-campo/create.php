<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SemillerosTicDiarioDeCampo */

$this->title = 'Semilleros Tic Diario De Campo';
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Tic Diario De Campos', 'url' => ['index']];
$this->params['breadcrumbs'][] = "Agregar";
?>
<div class="semilleros-tic-diario-de-campo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'fases' => $fases,
        'fasesModel' => $fasesModel,
    ]) ?>

</div>
