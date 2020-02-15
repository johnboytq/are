<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

// use yii\bootstrap\Collapse;
use nex\chosen\Chosen;

use app\models\PoblacionDocentesSesion;
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
		$poblacion = new PoblacionDocentesSesion();
		$idPE = 0;
	}
	else{
		$poblacion = PoblacionDocentesSesion::findOne([ 
						'id_poblacion_docentes' 	=> $idPE->id,
						'id_sesion'					=> $sesion->id,
					]);
	}
	// echo "<pre>"; var_dump( $idPE ); echo "</pre>";
	// echo "<pre>"; var_dump( $poblacion ); echo "</pre>";
	echo Html::activeHiddenInput( $poblacion, "[$index]id_sesion", [ 'value' => $sesion->id ] );
	// echo Html::activeHiddenInput( $poblacion, "[$index]id" );
	echo $form->field( $poblacion, "[$index]valor" )->textInput( ['autocomplete' => 'ñññ' ])->label( $sesion->descripcion );
	
	$index++;
}
?>

<div class="form-group">
	<?= Html::label( "Total", '', [ 'class'=>'control-label col-sm-2' ] ) ?>
	<div>
		<span></span>
		<div class="col-sm-8">
			<span total class='form-control' style='background:#eee;'></span>
		</div>
	</div>
</div>

