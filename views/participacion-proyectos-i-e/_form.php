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
/* @var $model app\models\ParticipacionProyectosIE */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participacion-proyectos-ie-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_institucion')->dropDownList( $institucion ) ?>
	
    <?= $form->field($model, 'programa_proyecto')->dropDownList( $nombresProyectos, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'participacion')->checkbox() ?>

    <?= $form->field($model, 'operador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entidad_financia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'objetivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_inicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anio_finalizacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tematica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sedes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_docentes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_estudiantes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_padres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_directivos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'materiales_recursos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
