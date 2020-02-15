<?php

use yii\models\Parametro;
use yii\helpers\Html;

use fedemotta\datatables\DataTables;
use yii\grid\GridView;

use yii\bootstrap\Collapse;

use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use nex\chosen\Chosen;

\Yii::$container->set('nex\chosen\Chosen', [
    'translateCategory' => 'app',
    'noResultsText' => 'Texto no encontrado ',
]);

/* @var $this yii\web\View */
/* @var $searchModel app\models\DimensionOpcionesSeguimientoDocenteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'INSTRUMENTO PARA EL SEGUIMIENTO DEL DOCENTE-TUTOR EN EL PROCESO DE ACOMPAÑAMIENTO';
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

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Html::encode( "DIRECTIVOS" ) ?></h1>
	
	<div class='form-group'>
		<label>Fecha:</label>
		
		<?= DatePicker::widget([
			// 'model' => $model,
			'name' 		=> 'Test',
			'language' => 'es',
			'attribute' => 'date',
			'template' => '{addon}{input}',
				'clientOptions' => [
					'autoclose' => true,
					'format' 	=> 'yyyy-mm-dd',
				]
		]);?>
	</div>

	
	<div class='form-group'>
		<label>Nombres y apellidos del Docente-Tutor</label>
		
		<?= Chosen::widget([
			'name' => 'ChosenTest2',
			// 'value' => 3,
			'items' => $docentes,
			'allowDeselect' => false,
			'disableSearch' => false, // Search input will be disabled
			'placeholder' => 'Seleccione...', // Search input will be disabled
			'clientOptions' => [
				'search_contains' => true,
				'max_selected_options' => 2,
			],
		]);?>

	</div>
	
	<div class='form-group'>
		<label>Nombres y Apellidos de quien diligencia</label>
		
		<?= Html::textInput( 'acompanamiento','',[ 'class' => 'form-control' ] ); ?>

	</div>
	
	<div class='form-group'>
		<label>Cargo de quien diligencia</label>
		
		<?= Html::textInput( 'persona-','',[ 'class' => 'form-control' ] ); ?>

	</div>
	
	<div class='form-group'>
		<label>IEO</label>
		
		<?= Chosen::widget([
			'name' => 'ChosenTest3',
			// 'value' => 3,
			'items' => $instituciones,
			'value' => $_SESSION['instituciones'][0],
			'allowDeselect' => false,
			'disableSearch' => false, // Search input will be disabled
			'placeholder' => 'Seleccione...', // Search input will be disabled
			'clientOptions' => [
				'search_contains' => true,
				'max_selected_options' => 2,
			],
		]);?>

	</div>
	
	<h3 style='background-color:#ccc;padding:10px;'>Instrumento para el seguimiento del Docente-Tutor en el proceso de acompañamiento.</h3>
    
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Collapse::widget([
		'items' => $items,
	]); ?>
</div>
