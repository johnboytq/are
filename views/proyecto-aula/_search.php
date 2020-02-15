<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectoAulaBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyecto-aula-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_grupo') ?>

    <?= $form->field($model, 'nombre_proyecto') ?>

    <?= $form->field($model, 'id_jornada') ?>

    <?= $form->field($model, 'id_persona_coordinador') ?>

    <?= $form->field($model, 'correo') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'avance_1') ?>

    <?php // echo $form->field($model, 'avance_2') ?>

    <?php // echo $form->field($model, 'avance_3') ?>

    <?php // echo $form->field($model, 'avance_4') ?>

    <?php // echo $form->field($model, 'Id_sede') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
