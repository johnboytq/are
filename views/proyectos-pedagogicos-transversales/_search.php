<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectosPedagogicosTransversalesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyectos-pedagogicos-transversales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo_grupo') ?>

    <?= $form->field($model, 'nombre_grupo') ?>

    <?= $form->field($model, 'coordinador') ?>

    <?= $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'correo') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'linea_investigacion_1') ?>

    <?php // echo $form->field($model, 'linea_investigacion_2') ?>

    <?php // echo $form->field($model, 'linea_investigacion_3') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
