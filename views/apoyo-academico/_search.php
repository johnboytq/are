<?php
if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ApoyoAcademicoBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apoyo-academico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_persona_doctor') ?>

    <?= $form->field($model, 'registro') ?>

    <?= $form->field($model, 'id_persona_estudiante') ?>

    <?= $form->field($model, 'motivo_consulta') ?>

    <?php // echo $form->field($model, 'fecha_entrada') ?>

    <?php // echo $form->field($model, 'hora_entrada') ?>

    <?php // echo $form->field($model, 'fecha_salida') ?>

    <?php // echo $form->field($model, 'hora_salida') ?>

    <?php // echo $form->field($model, 'incapacidad')->checkbox() ?>

    <?php // echo $form->field($model, 'no_dias_incapaciad') ?>

    <?php // echo $form->field($model, 'discapacidad')->checkbox() ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <?php // echo $form->field($model, 'id_tipo_apoyo') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
