<?php

/**********
Versión: 001
Fecha: 2018-08-21
Desarrollador: Edwin Molina Grisales
Descripción: Formulario EJECUCION FASE III
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
	
	.title3 > div > span{
		height: 120px;
	}
</style>

<div class="ejecucion-fase-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<h3 style='background-color:#ccc;padding:5px;'><?= Html::encode( 'DATOS IEO' ) ?></h3>
	
	<?= $form->field($model, 'id_fase')->dropDownList( $institucion, [ 'prompt' => 'Seleccione...' ] )->label( 'Institución educativa' )?>

    <?= $form->field($model, 'id_datos_sesiones')->dropDownList( $sede, [ 'prompt' => 'Seleccione...' ] )->label( 'Sede' ) ?>
	
	<h3 style='background-color:#ccc;padding:5px;'><?= Html::encode( 'DATOS PROFESIONALES' ) ?></h3>

    <?= $form->field($model, 'docente')->dropDownList( $docentes, [ 'prompt' => 'Seleccione...' ] )->label('Profesional A.') ?>
	
	<h3 style='background-color:#ccc;padding:5px;'><?= Html::encode($fase->descripcion) ?></h3>
	
	<div class='container-fluid'>
		
		<div class='row text-center title'>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre del docente creador</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Asignatura en la que se usa la aplicaión</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre del docente usuario de la Aplicación</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Grado en el que se usa la aplicación</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Número de estudiantes cultivadores</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Número de Apps 0.0 usadas</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Nombre de las aplicaciones usadas</span>
			</div>
			
			
		</div>
		
		<div class='row text-center'>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]seiones_empleadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]acciones_realiadas', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]temas_problama', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]tipo_conpetencias', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]observaciones',[ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]id_datos_ieo_profesional', [ 'class' => 'form-control' ]) ?>
			</div>
			
		</div>
		
		
		
		
	
	
	
	
	
	
		<div class='row text-center'>
			
			<div class='col-sm-12'>
				<span total class='form-control' style='background-color:#ccc;'>Recursos empleados para usar las App 0.0</span>
			</div>
			
		</div>
		
		<div class='row text-center title3'>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>TIC (infraestructura existente en la IEO)</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Tipo de Uso del Recurso</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Digitales</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Tipo de Uso del Recurso</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Escolares (No TIC)</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Tipo de Uso del Recurso</span>
			</div>
			
			<div class='col-sm-1'>
				<span total class='form-control' style='background-color:#ccc;'>Tiempo de uso de los recursos TIC en el uso de las App 0.0 (Horas)</span>
			</div>
			
		</div>
		
		<div class='row text-center'>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-1'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
		
		
		
		
		
		
		
		
		
		
		
		<div class='row text-center'>
			
			<div class='col-sm-4'>
				<span total class='form-control' style='background-color:#ccc;'>Obras derivadas en el uso de las App 0.0</span>
			</div>
			
			<div class='col-sm-6'>
				<span total class='form-control' style='background-color:#ccc;'></span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'></span>
			</div>
			
		</div>
		
		<div class='row text-center title2'>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Número</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Tipo de producción</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Indice de temas escolares disciplinares tratados y abordados a través del uso de las  App 0.0</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Indice de problematicas abordadas a través del uso de las  App 0.0</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>Fecha de Uso de las aplicaciones</span>
			</div>
			
			<div class='col-sm-2'>
				<span total class='form-control' style='background-color:#ccc;'>OBSERVACIONES GENERALES</span>
			</div>
			
		</div>
		
		<div class='row text-center'>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-2'>
				<?= Html::activeTextInput($model, '[$index]numero_apps', [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
		</div>
		
		
	<br>	
		
	<?= $form->field($model, 'id_fase')->textInput()->label( 'Total aplicaciones usadas' )?>

    <?= $form->field($model, 'id_datos_sesiones')->textInput()->label( 'Número de estudiantes cultivadores' ) ?>
	
	
		
	</div>
	
	


	<?php ActiveForm::end(); ?>

</div>
