<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SemillerosDatosIeoEstudiantesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semilleros-datos-ieo-estudiantes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_institucion') ?>

    <?= $form->field($model, 'profecional_a') ?>

    <?= $form->field($model, 'docente_aliado') ?>

    <?= $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
