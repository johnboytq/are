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

$this->title = 'AUTOEVALUACIÓN PROCESO DE FORMACIÓN CON DOCENTES TUTORES';
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
	
	<div class='form-group'>
		<label>Fecha:</label>
		
		<?= DatePicker::widget([
			// 'model' => $model,
			'name' => 'Test',
			'attribute' => 'date',
			'language' => 'es',
			'template' => '{addon}{input}',
				'clientOptions' => [
					'autoclose' => true,
					'format' 	=> 'yyyy-mm-dd',
				]
		]);?>
	</div>

	
	<div class='form-group'>
		<label>Nombres y Apellidos del docente tutor:</label>
		
		<?= Chosen::widget([
			'name' => 'ChosenTest',
			// 'value' => 3,
			'items' => $docentes,
			'allowDeselect' => false,
			'disableSearch' => false, // Search input will be disabled
			'placeholder' => 'Seleccione...', // Search input will be disabled
			'clientOptions' => [
				'search_contains' => true,
				'max_selected_options' => 2,
				'no_results_text' => 'asdfasdfasfd',
			],
		]);?>

	</div>
	
	<div style='padding:10px;'>
		<span>
			<p>Estimado(a) docente tutor(a)</p>
			
			<p>La autoevaluación nos posibilita reflexionar sobre nuestro propio aprendizaje y hacer manifiestos los progresos y aspectos por mejorar, optimizando con ello nuestra capacidad de gestionar la manera como aprendemos.<p>

			<p>Teniendo en cuenta lo anterior, le invitamos a responder estas preguntas.</p>
		</span>
	</div>
    
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= Collapse::widget([
		'items' => $items,
	]); ?>
</div>
