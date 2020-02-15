<?php

use yii\models\Parametro;
use yii\helpers\Html;

use fedemotta\datatables\DataTables;
use yii\grid\GridView;

use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DimensionOpcionesSeguimientoDocenteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instrumento de autoevaluación al Docente-Tutor en el proceso de acompañamiento';
// $this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Instrumento autoevaluación";

foreach( $dimensiones as $key => $dimension ){
	
	$items[] = 	[
		'label' 		=>  $dimension,
		'content' 		=>  $this->render( 'itemDimension', 
										[ 
											'parametros'=> $parametros,
											'dimension'	=> $key,
										] 
							),
		'contentOptions'=> []
	];
}
?>


<div class="dimension-opciones-seguimiento-docente-index">

    <h1><?= Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Collapse::widget([
		'items' => $items,
	]); ?>
</div>
