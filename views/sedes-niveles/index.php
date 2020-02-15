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
/*
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\ArrayHelper;

use app\models\Sedes;
use app\models\Niveles;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SedesNivelesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Niveles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-niveles-index">

    <h1><?= Html::encode($modelInstitucion->descripcion) ?></h1>
    <h3><?= Html::encode( "SEDE ". $modelSedes->descripcion) ?></h1>
	
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

			[
				'attribute' => 'id_niveles',
				'value' 	=> function( $model ){
					$niveles = Niveles::findOne($model->id_niveles);
					return $niveles ? $niveles->descripcion : '';
				},
				'filter' => ArrayHelper::map(Niveles::find()->all(), 'id', 'descripcion' ),
			],
			// [
				// 'attribute' => 'id_sedes',
				// 'value' 	=> function( $model ){
					// $sedes = Sedes::findOne($model->id_sedes);
					// return $sedes ? $sedes->descripcion : '';
				// },
				// 'filter' => ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			// ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
