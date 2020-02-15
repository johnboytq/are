<?php
/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: Formulario CONFORMACION SEMILLEROS TIC ESTUDIANTES
				Muestrea la vista del acordeon de fases
---------------------------------------
**********/

use app\models\PoblacionDocentesSesion;
use app\models\Sesiones;

$items = [];
$index = 0;

foreach( $fases as $keyFase => $fase ){
	
	$sesiones = Sesiones::find()
					->andWhere( 'id_fase='.$fase->id )
					->all();
	
	$items[] = 	[
					'label' 		=>  $fase->descripcion,
					'content' 		=>  $this->render( 'faseItem', 
													[ 
														'idPE' 		=> $idPE, 
														'index' 	=> $index,
														'sesiones' 	=> $sesiones,
														'fase' 		=> $fase,
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