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
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Sedes;
use app\models\AreasEnsenanza;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SedesAreasEnsenanzaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Especialidad';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-areas-ensenanza-index">

    <h1><?= Html::encode( $modelInstitucion->descripcion ) ?></h1>
    <h3><?= Html::encode( "SEDE ".$modelSedes->descripcion ) ?></h3>
	
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create', 'idSedes' => $modelSedes->id ], ['class' => 'btn btn-success']) ?>
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

			// [
				// 'attribute' => 'id_sedes',
				// 'value' 	=> function( $model ){
									// $sedes = Sedes::findOne($model->id_sedes);
									// return $sedes ? $sedes->descripcion : '';
							   // },
				// 'filter' 	=> ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			// ],
   			[
				'attribute' => 'id_areas_ensenanza',
				'value' 	=> function( $model ){
									$sedes = AreasEnsenanza::findOne($model->id_areas_ensenanza);
									return $sedes ? $sedes->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map(AreasEnsenanza::find()->all(), 'id', 'descripcion' ),
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
