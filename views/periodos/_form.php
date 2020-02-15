<?php
/**********
Versión: 001
Fecha: 17-03-2018
---------------------------------------
Modificaciones:
Fecha: 08-07-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Se agrega script para validar que la fecha inicial no sea mayor a la fecha final
---------------------------------------
**********/

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

$this->registerJsFile(
    '@web/js/periodos.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

/* @var $this yii\web\View */
/* @var $model app\models\Periodos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_inicio')->widget(
    DatePicker::className(), [
        
		 // modify template for custom rendering
		'template' => '{addon}{input}',
		'language' => 'es',
		'clientOptions' => [
			'autoclose' => true,
			'format' 	=> 'yyyy-mm-dd',
		],
	]);  ?>

    <?= $form->field($model, 'fecha_fin')->widget(
    DatePicker::className(), [
        
		 // modify template for custom rendering
		'template' => '{addon}{input}',
		'language' => 'es',
		'clientOptions' => [
			'autoclose' => true,
			'format' => 'yyyy-mm-dd',
		]
	]); ?>
	
	<?= $form->field($model, 'estado')->dropDownList($estados) ?>
	
	<?= $form->field($model, 'id_sedes')->hiddenInput(['value'=> $idSedes])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
