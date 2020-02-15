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

/**********
Versión: 001
Fecha: 27-03-2018
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Se agrega el js plan_de_aulas.js que permite traer las asignaturas dinamicamente de acuerdo al nivel seleccionado
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/plan_de_aulas.js',['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $model app\models\PlanDeAula */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-de-aula-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'id_periodo')->dropDownList( $periodos, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_nivel')->dropDownList( $niveles, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'id_asignatura')->dropDownList( $asignaturas, [ 'prompt' => 'Seleccione...' ] ) ?>

	<?= $form->field($model, 'fecha')->widget(
		DatePicker::className(), [
			
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => [
				'autoclose' 	=> true,
				'format' 		=> 'yyyy-mm-dd',
			]
	]);?> 	 		

    <?= $form->field($model, 'actividad')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese la actividad' ]) ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => '6','placeholder' => 'Ingrese las observaciones']) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>
	
	<?= $form->field($model, 'id_indicador_desempeno')->dropDownList( $indicadorDesempenos, [ 'prompt' => 'Seleccione...'  ]) ?>
		
	<?= $form->field($model, 'cognitivo_conocer')->checkbox() ?>

	<?= $form->field($model, 'cognitivo_hacer')->checkbox() ?>

	<?= $form->field($model, 'cognitivo_ser')->checkbox() ?>

	<?= $form->field($model, 'personal')->checkbox() ?>

	<?= $form->field($model, 'social')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
