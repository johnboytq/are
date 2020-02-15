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
/* @var $model app\models\Instituciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instituciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'placeHolder' => 'Digite la descripción' ]) ?> 
	
	<?= $form->field($model, 'caracter')->textInput(['maxlength' => true, 'placeHolder' => 'Ej: Media Técnica']) ?>
	
	<?= $form->field($model, 'especialidad')->textInput(['maxlength' => true, 'placeHolder' => 'Ej: Sistemas']) ?>
	
	<?= $form->field($model, 'rector')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el nombre del rector']) ?>

    <?= $form->field($model, 'contacto_rector')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el contacto del rector']) ?>
	
	<?= $form->field($model, 'codigo_dane')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el código DANE']) ?>

    <?= $form->field($model, 'id_tipos_instituciones')->dropDownList( $tipoInstituciones, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_sectores')->dropDownList( $sectores, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'nit')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el NIT']) ?>

    <?= $form->field($model, 'correo_electronico_institucional')->textInput(['maxlength' => true, 'placeHolder' => 'Digite el correo de la institución']) ?>

    <?= $form->field($model, 'pagina_web')->textInput(['maxlength' => true, 'placeHolder' => 'Digite la página web']) ?>
    
	<?= $form->field($model, 'estado')->dropDownList( $estados ) ?> 

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
