<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularBitacorasVisitasIeoBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gestion-curricular-bitacoras-visitas-ieo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha_inicio') ?>

    <?= $form->field($model, 'fecha_fin') ?>

    <?= $form->field($model, 'id_persona_docente_tutor') ?>

    <?= $form->field($model, 'id_institucion') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <?php // echo $form->field($model, 'id_jornada') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
