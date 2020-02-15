<?php
if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}
/**********
Versión: 001
Fecha: Fecha en formato (10-03-2018)
Desarrollador: Viviana Rodas
Descripción: Lista de formaciones
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Personas;
use app\models\TiposFormaciones;

use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasFormacionesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas Formaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-formaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
	

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'clientOptions' => [
		'language'=>[
                'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
            ],
		"lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
		"info"=>false,
		"responsive"=>true,
		 "dom"=> 'lfTrtip',
		 "tableTools"=>[
			 "aButtons"=> [  
				// [
				// "sExtends"=> "copy",
				// "sButtonText"=> Yii::t('app',"Copiar")
				// ],
				// [
				// "sExtends"=> "csv",
				// "sButtonText"=> Yii::t('app',"CSV")
				// ],
				[
				"sExtends"=> "xls",
				"oSelectorOpts"=> ["page"=> 'current']
				],
				[
				"sExtends"=> "pdf",
				"oSelectorOpts"=> ["page"=> 'current']
				],
				// [
				// "sExtends"=> "print",
				// "sButtonText"=> Yii::t('app',"Imprimir")
				// ],
			],
		 ],
	],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			//para mostrar el nombre en en la lista
            [
				'attribute'=>'id_personas',
				'value' => function( $model )
				{
					$personas = Personas::findOne($model->id_personas);
					return $personas ? $personas->nombres : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(Personas::find()->all(), 'id', 'nombres' ),
				
			],
			//para mostrar la descripcion
            [
				'attribute'=>'id_tipos_formaciones',
				'value' => function( $model )
				{
					$formaciones = TiposFormaciones::findOne($model->id_tipos_formaciones);
					return $formaciones ? $formaciones->descripcion : '';
				}, //para buscar por la descripcion
				'filter' 	=> ArrayHelper::map(TiposFormaciones::find()->all(), 'id', 'descripcion' ),
				
			],
            'horas_curso',
            'ano_curso',
            'titulacion:boolean',
            //'titulo',
            //'institucion',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); 
	?>
</div>
