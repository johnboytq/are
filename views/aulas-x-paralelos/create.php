<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AulasXParalelos */

$this->title = 'Agregar aula por grupo';
$this->params['breadcrumbs'][] = ['label' => 'Aulas Xparalelos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aulas-xparalelos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 			=> $model,
        'grupos' 			=> $grupos,
        'aulas' 			=> $aulas,
        'paralelosSearch' 	=> $paralelosSearch,
        'nivelesSearch' 	=> $nivelesSearch,
        'niveles' 			=> $niveles,
        'jornadas' 			=> $jornadas,
    ]) ?>

</div>
