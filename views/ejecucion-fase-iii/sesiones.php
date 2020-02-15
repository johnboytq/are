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

use app\models\PoblacionDocentesSesion;
use app\models\Sesiones;
use app\models\CondicionesInstitucionales;

$items = [];
$index = 0;

$sesiones = Sesiones::find()
				->where( 'id_fase=1' )
				->andWhere( 'estado=1' )
				->all();

// $condiciones = CondicionesInstitucionales::find()
				// ->andWhere( 'estado=1' )
				// ->all();
				
$condiciones = new CondicionesInstitucionales();

$i = 0;
foreach( $sesiones as $keySesion => $sesion ){
	
	$i++;
	
	$items[] = 	[
					'label' 		=>  "Registro ".$i,
					'content' 		=>  $this->render( 'sesionItem', 
													[ 
														'idPE' 			=> $idPE, 
														'index' 		=> $index,
														'sesion' 		=> $sesion,
														'model' 		=> $model,
														'condiciones'	=> $condiciones,
														'institucion'	=> $institucion,
														'sede'			=> $sede,
														'docentes'		=> $docentes,
														'fase'		=> $fase,
													] 
										),
					'contentOptions'=> []
				];
				
	$index += count($sesiones);
}

use yii\bootstrap\Collapse;

echo Collapse::widget([
    'items' => $items,
]);

?>

<div class='container-fluid' style='margin:10px 0;'>
	
		<div class='row text-center'>
			
			<div class='col-sm-12'>
				<span total class='form-control' style='background-color:#ccc;'>CONDICIONES INSTITUCIONALES</span>
			</div>
		
		</div>
		
		<div class='row text-center title2'>
		
			<div class='col-sm-3'>
				<span total class='form-control' style='background-color:#ccc;'>Por parte de la IEO</span>
			</div>
			
			<div class='col-sm-3'>
				<span total class='form-control' style='background-color:#ccc;'>Por parte de UNIVALLE</span>
			</div>
			
			<div class='col-sm-3'>
				<span total class='form-control' style='background-color:#ccc;'>Por parte de la SEM</span>
			</div>
			
			<div class='col-sm-3'>
				<span total class='form-control' style='background-color:#ccc;'>OTRO</span>
			</div>
			
		</div>
		
		<div class='row text-center'>
			
			<div class='col-sm-3'>
				<?= Html::activeTextInput($condiciones, "[$index]parte_ieo", [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-3'>
				<?= Html::activeTextInput($condiciones, "[$index]parte_univalle", [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-3'>
				<?= Html::activeTextInput($condiciones, "[$index]parte_sem", [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>
			
			<div class='col-sm-3'>
				<?= Html::activeTextInput($condiciones, "[$index]otro", [ 'class' => 'form-control', 'maxlength' => true]) ?>
			</div>

		</div>
		
	</div>