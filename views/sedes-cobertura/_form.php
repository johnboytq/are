<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SedesCobertura */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-cobertura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sede')->textInput() ?>

    <?= $form->field($model, 'id_tema')->textInput() ?>

    <?= $form->field($model, 'ninos')->textInput() ?>

    <?= $form->field($model, 'ninas')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
