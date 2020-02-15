<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SedesCobertura */

$this->title = 'Create Sedes Cobertura';
$this->params['breadcrumbs'][] = ['label' => 'Sedes Coberturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-cobertura-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
