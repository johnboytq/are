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
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se quita columna ID y sedes, este último por que hace parte del titulo y todas son iguales
					- Se crea titulo con el nombre de la institución y el nombre de la sedes
					- Se muestra en nombre de la jornada en lugar de su id
					- Al botron agregar, envío el id de la institución
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Jornadas;
use app\models\Sedes;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jornadas';
$this->params['breadcrumbs'][] = $this->title;

$modelInstitucion 	= Instituciones::findOne( $idInstitucion );
$modelSedes 		= Sedes::findOne( $idSedes );
?>
<div class="sedes-jornadas-index">
    
    <h1><?= Html::encode($modelInstitucion->descripcion) ?></h1>
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
        'dataProvider' => $dataProvider,
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
				// 'value' => function( $model ){
					// $sedes = Sedes::findOne($model->id_sedes);
					// return $sedes ? $sedes->descripcion : '';
				// },
				// 'filter' => ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			// ],
			[
				'attribute' => 'id_jornadas',
				'value' => function( $model ){
					$jornadas = Jornadas::findOne($model->id_jornadas);
					return $jornadas ? $jornadas->descripcion : '';
				},
				'filter' => ArrayHelper::map(Jornadas::find()->all(), 'id', 'descripcion' ),
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
