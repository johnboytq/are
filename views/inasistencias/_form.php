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
/* @var $model app\models\Inasistencias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inasistencias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_perfiles_x_personas_estudiantes')->textInput() ?>

    <?= $form->field($model, 'justificada')->checkbox() ?>

    <?= $form->field($model, 'id_distribuciones_academicas')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'justificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'fecha_ing')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
