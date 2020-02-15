<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

// use yii\bootstrap\Collapse;
use nex\chosen\Chosen;

use app\models\EstudiantesOperativoSesion;
use app\models\Sesiones;

$form = ActiveForm::begin([
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
	]);

foreach( $sesiones as $keySesion =>$sesion ){
		
	if( !$idPE ){
		$poblacion = new EstudiantesOperativoSesion();
		$idPE = 0;
	}
	else{
		$poblacion = EstudiantesOperativoSesion::findOne([ 
						'id_estudiantes_operativo' 	=> $idPE->id,
						'id_sesion'					=> $sesion->id,
					]);
	}


	echo Html::activeHiddenInput( $poblacion, "[$index]id_sesion", [ 'value' => $sesion->id ] );

	?>
	
	<div class='container' style='padding:5px;'>
		
		<div class='row' style='background-color:#ccc;'>
			
			<div class='col-sm-12 text-center'>
				<h4><?= $sesion->descripcion; ?></h4>
			</div>
			
		</div>
		
		<div class='row' style='background-color:#eee;'>
			
			<div class='col-sm-12'>
				<?= $form->field( $poblacion, "[$index]asistentes" )->textInput( ['autocomplete' => 'ñññ' ]); ?>
				<?= $form->field( $poblacion, "[$index]dificultades_operativas" )->textInput( ['autocomplete' => 'ñññ' ]); ?>
			</div>
		
		</div>
		
	</div>
	
	<?php
	
	$index++;
}
?>

<div class="form-group">
	<?= Html::label( "Número de estudiantes participantes", '', [ 'class'=>'control-label col-sm-2' ] ) ?>
	<div>
		<span></span>
		<div class="col-sm-8">
			<span total class='form-control' style='background:#eee;'></span>
		</div>
	</div>
</div>

