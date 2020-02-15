<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IndiceSinteticoCalidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indice-sintetico-calidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'anio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_indice_especifico')->dropDownList( $indicesEspecificos, [ 'prompt' => 'Seleccione...'] ) ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
