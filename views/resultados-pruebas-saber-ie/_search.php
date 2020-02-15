<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberIeBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="resultados-pruebas-saber-ie-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'anio') ?>

    <?= $form->field($model, 'id_asignatura_especifica') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'id_institucion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
