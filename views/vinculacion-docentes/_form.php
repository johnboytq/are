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

use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\VinculacionDocentes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vinculacion-docentes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'id_perfiles_x_personas_docentes' )->dropDownList( $personas, [ 'prompt' => 'Seleccione...' ] ) ?>
    
	<?= $form->field($model, 'resolucion_numero')->textInput( ['maxlength' => true, 'placeholder' => 'Digite el número de la resolución' ] ) ?>

	<?= $form->field($model, 'resolucion_desde')->widget(
		DatePicker::className(), [
			
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => [
				'autoclose' 	=> true,
				'format' 		=> 'yyyy-mm-dd',
			]
	]);?> 	 		

    <?= $form->field($model, 'antiguedad')->textInput(['maxlength' => true, 'placeholder' => 'Digite la antigüedad']) ?>

    <?= $form->field($model, 'id_tipos_contratos')->dropDownList( $tiposContratos, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
