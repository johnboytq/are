<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EjecucionFaseIBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejecucion-fase-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_fase') ?>

    <?= $form->field($model, 'id_datos_sesiones') ?>

    <?= $form->field($model, 'docente') ?>

    <?= $form->field($model, 'asignaturas') ?>

    <?php // echo $form->field($model, 'especiaidad') ?>

    <?php // echo $form->field($model, 'paricipacion_sesiones') ?>

    <?php // echo $form->field($model, 'numero_apps') ?>

    <?php // echo $form->field($model, 'seiones_empleadas') ?>

    <?php // echo $form->field($model, 'acciones_realiadas') ?>

    <?php // echo $form->field($model, 'temas_problama') ?>

    <?php // echo $form->field($model, 'tipo_conpetencias') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'id_datos_ieo_profesional') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'numero_sesiones_docente') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
