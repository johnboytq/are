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
Fecha: 02-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de aulas
---------------------------------------
Modificaciones:
Fecha: 03-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se crea el buscador para la tabla aulas
---------------------------------------
Fecha: 03-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se cambia boton Create aulas por Agregar
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agrega data tables
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Sedes;
use app\models\TiposAulas;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aulas';
$this->params['breadcrumbs'][] = $this->title;

$sedes 	 	 = Sedes::findOne( $idSedes );
$institucion = Instituciones::findOne($sedes->id_instituciones);
?>
<div class="aulas-index">

    <h1><?= Html::encode($institucion->descripcion) ?></h1>
    <h3><?= Html::encode($sedes->descripcion) ?></h1>
	
    <h1><?= Html::encode($this->title) ?></h1>

	 <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
	
    <p>
        <?= Html::a('Agregar', ['create', 'idSedes' => $idSedes ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
        'dataProvider' 	=> $dataProvider,
        'filterModel' 	=> $searchModel,
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
			
            'descripcion',
			[
				'attribute' => 'id_tipos_aulas',
				'value' => function( $model ){
					$tiposAulas = TiposAulas::findOne($model->id_tipos_aulas);
					return $tiposAulas ? $tiposAulas->descripcion : '';
				},
				'filter' => ArrayHelper::map(TiposAulas::find()->all(), 'id', 'descripcion' ),
			],
            'capacidad',
           // [
				// 'attribute' => 'id_sedes',
				// 'value' => function( $model ){
					// $sedes = Sedes::findOne($model->id_sedes);
					// return $sedes ? $sedes->descripcion : '';
				// },
				// 'filter' => ArrayHelper::map(Sedes::find()->where( 'id='.$idSedes )->all(), 'id', 'descripcion' ),
			// ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
