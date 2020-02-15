<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularDocenteTutorAcompanamientoBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gestion-curricular-docente-tutor-acompanamiento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'nombre_profesional_acompanamiento') ?>

    <?= $form->field($model, 'id_docente') ?>

    <?= $form->field($model, 'id_institucion') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
