<?php

/**********
Versión: 001
Fecha: 2018-08-21
Desarrollador: Edwin Molina Grisales
Descripción: Formulario EJECUCION FASE I
---------------------------------------
**********/

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\EjecucionFase */
/* @var $form yii\widgets\ActiveForm */

// $form1 = ActiveForm::begin(
	// [
		// 'layout' => 'horizontal',
		// 'fieldConfig' => [
			// 'template' => "{beginWrapper}\n{input}\n{endWrapper}",
			// 'horizontalCssClasses' => [
				// 'label' 	=> 'col-sm-0',
				// 'offset' 	=> 'col-sm-offset-2',
				// 'wrapper' 	=> 'col-sm-1',
				// 'error' 	=> '',
				// 'hint' 		=> '',
				// 'input' 	=> 'col-sm-1',
			// ],
		// ],
	// ]
	// );
?>

<style>
	.col-sm-12, .col-sm-11, .col-sm-10, .col-sm-9, .col-sm-8, .col-sm-7, .col-sm-6, .col-sm-5, .col-sm-4, .col-sm-3, .col-sm-2, .col-sm-1{
		padding: 0px;
	}
	
	.title{
		height: 150px;
	}
	
	.title > div > span{
		height: 150px;
	}
	
	.title2 > div > span{
		height: 70px;
	}
</style>

<div class="ejecucion-fase-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class='container-fluid'>
	
		<?= $form->field($model, '['.$index.']numero_apps')->widget(
			DatePicker::className(), [
				
				 // modify template for custom rendering
				'template' => '{addon}{input}',
				'language' => 'es',
				'clientOptions' => [
					'autoclose' => true,
					'format' => 'dd-mm-yyyy'
				]
		])->label('Fecha de la sesión(dd-mm-aaaa)');?> 	
		
		<div class='row text-center'>
			
			<div class='col-sm-12'>
				<span total class='form-control' style='background-color:#ccc;'>FASE I CREACIÓN Y PRUEBA</span>
			</div>
			
		</div>
		
		<div class='row text-center title'>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre del docente</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre de las asignaturas que enseña</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Especialidad de la Media Técnica o Técnica</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Participación Sesiones(1 a 6)</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Número de Apps 0.0 creadas</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre de las aplicaciones creadas</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Número de sesiones empleadas para la creación de cada aplicación</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Acciones realizadas con mayor incidencia para estimular la creación de las App 0.0</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Temas problema que atiende la cración</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Tipo de competencias inferencias y comprometidas en el proceso de creación de la App 0.0</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Observaciones</span>
			</div>
			
		</div>
		
		<div class='row text-center'>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]estado', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
	
		<div class='row text-center'>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]estado', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
	
		<div class='row text-center'>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]estado', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
	
		<div class='row text-center'>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]estado', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
	
		<div class='row text-center'>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]estado', [ 'class' => 'form-control' ]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_sesiones_docente', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
	
		
	</div>
	
	


	<?php ActiveForm::end(); ?>

</div>
