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
/* @var $model app\models\CalificacionesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificaciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'calificacion') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'observaciones') ?>

    <?= $form->field($model, 'id_perfiles_x_personas_docentes') ?>

    <?php // echo $form->field($model, 'id_perfiles_x_personas_estudiantes') ?>

    <?php // echo $form->field($model, 'id_asignaciones_x_indicador_desempeno') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
