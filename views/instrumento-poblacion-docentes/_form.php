<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

// use yii\bootstrap\Collapse;
use nex\chosen\Chosen;

$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");
$this->registerJsFile(
    '@web/js/instrumentoPoblacionDocentes.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

/* @var $this yii\web\View */
/* @var $model app\models\InstrumentoPoblacionEstudiantes */
/* @var $form yii\widgets\ActiveForm */
// if( $model->isNewRecord ) echo "es nuevo";
// if( !$model->isNewRecord ) echo "noes es nuevo";
// echo "<pre>"; 
// var_dump( $estados );
// echo "</pre>"; 
?>

<div class="instrumento-poblacion-docentes-form" style='padding:10px'>

	<div>

    <?php $form = ActiveForm::begin([
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'label' 	=> 'col-sm-2',
				'offset' 	=> 'col-sm-offset-2',
				'wrapper' 	=> 'col-sm-8',
				'error' 	=> '',
				'hint' 		=> '',
				'input' 	=> 'col-sm-2',
			],
		],
	]); ?>

	<div class='row'>
		
		<div class='col-sm-4'>
		
			<?= $form->field($model, 'id_institucion')->widget(
				Chosen::className(), [
					'items' => $instituciones,
					'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
					'placeholder' => 'Seleccione...',
					'clientOptions' => [
						'search_contains' => true,
						'single_backstroke_delete' => false,
					],
			]);?>

			<?= $form->field($model, 'id_sede')->widget(
				Chosen::className(), [
					'items' => $sedes,
					'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
					'placeholder' => 'Seleccione...',
					'clientOptions' => [
						'search_contains' => true,
						'single_backstroke_delete' => false,
					],
			]);?>
		
		</div>
		
		<div id='dv-institucion-sede' class='col-sm-8'>
		</div>
	</div>

	
	<div class='row'>
		
		<div class='col-sm-4'>
			<?= $form->field($model, 'id_persona')->widget(
				Chosen::className(), [
					'items' => $estudiantes,
					'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
					'placeholder' => 'Seleccione...',
					'clientOptions' => [
						'search_contains' => true,
						'single_backstroke_delete' => false,
					],
			]);?>
			
			<?= $form->field($model, 'id_niveles')->widget(
				Chosen::className(), [
					'items' => $estudiantes,
					'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
					'placeholder' => 'Seleccione...',
					'clientOptions' => [
						'search_contains' => true,
						'single_backstroke_delete' => false,
					],
			]);?>
		
			<?= $form->field($model, 'id_asignaturas_niveles_sedes')->widget(
				Chosen::className(), [
					'items' => $estudiantes,
					'disableSearch' => 5, // Search input will be disabled while there are fewer than 5 items
					'placeholder' => 'Seleccione...',
					'clientOptions' => [
						'search_contains' => true,
						'single_backstroke_delete' => false,
					],
			])->label('Asignatura');?>
			
			<?= $form->field($model, 'profesion')->textInput();?>
			
			<?= $form->field($model, 'ultimo_nivel')->textInput();?>
		</div>
		
		<div id='dv-estudiante' class='col-sm-8'>
		</div>
		
	</div>
	

    <?= Html::activeHiddenInput( $model, 'estado', [ 'value' => $estados ] ) ?>

    <div id='dv-fases' class="form-group" style='padding:5px;'>
	</div>
	
    <div class="form-group">
		<?= Html::buttonInput('Guardar', [ 'id'=>'bt-guardar', 'class'=>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


