<?php

use app\models\PoblacionEstudiantesSesion;
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