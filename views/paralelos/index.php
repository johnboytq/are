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


use yii\helpers\Html;
use yii\grid\GridView;

use app\models\SedesJornadas;
use app\models\SedesNiveles;
use yii\helpers\ArrayHelper;
use app\models\Sedes;
use app\models\Jornadas;
use app\models\Niveles;
use app\models\Instituciones;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


/**********
Versión: 001
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Paralelos
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - modificacion de los datos en GridView para mostrar los datos correctos donde corresponde el Id
de la tabla
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
**********/


$this->title = 'Grupos por nivel';
$this->params['breadcrumbs'][] = $this->title;

$modelInstitucion 	= Instituciones::findOne( $idInstitucion );
$modelSedes 		= Sedes::findOne( $idSedes );
?>
<div class="paralelos-index">

<h1><?= Html::encode($modelInstitucion->descripcion) ?></h1>
  <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
	<h3><?= Html::encode( "SEDE: ".$modelSedes->descripcion) ?></h3>

    <p>
        <?= Html::a('Agregar', [
									'create',
									'idSedes' 		=> $idSedes,
									'idInstitucion' => $idInstitucion, 
								], 
								['class' => 'btn btn-success'
		]) ?>
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
				'attribute'=>'id_sedes_jornadas',
				/*
				se consulta el nombre de la sede pasando por la tabla sedes_jornadas usando 
				*/
				'value' => function( $model ){
					$sedesJornadas = SedesJornadas::findOne($model->id_sedes_jornadas);
					
					
					$idSede = $sedesJornadas ? $sedesJornadas->id_sedes : '';
					$idSede =(int) $idSede;
					$sedes = Sedes::findOne($model->id=$idSede);
					$sedes= $sedes ? $sedes->descripcion : '';
					
					
					return  $sedes ;	
				},
				'label'=>'Sedes'
				
			],
			[
				'attribute'=>'id_sedes_jornadas',
				/*
				se consulta el nombre de la jornada pasando por la tabla sedes_jornadas
				*/
				'value' => function( $model ){
					$sedesJornadas = SedesJornadas::findOne($model->id_sedes_jornadas);
										
					
					$idJornada = $sedesJornadas ? $sedesJornadas->id_jornadas : '';
					$idJornada = (int)$idJornada;
					$jornadas = Jornadas::findOne($model->id= $idJornada);
					$jornadas= $jornadas ? $jornadas->descripcion : '';
						
					
					return  $jornadas;	
				},
				'label'=>'Jornadas'
				
			],
            [
			
				'attribute'=>'id_sedes_niveles',
				/*
				se consulta el nombre del nivel pasando por la tabla sedes_niveles
				*/
				'value' => function( $model )
				{					
						
					$sedesNiveles = SedesNiveles::findOne($model->id_sedes_niveles);
					
					//Jornadas
					$idNiveles = $sedesNiveles ? $sedesNiveles->id_niveles : '';
					$idNiveles = (int)$idNiveles;
					
					$niveles = Niveles::findOne($model->id= $idNiveles);
					$niveles= $niveles ? $niveles->descripcion : '';
					//Jornadas
					
					
					return  $niveles;	
				},
				'label'=>'Niveles'
				
			],
            
            'ano_lectivo',
            //'fecha_ingreso',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
