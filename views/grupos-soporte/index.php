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
Fecha: 13-04-2018
Persona encargada: Viviana Rodas
CRUD de grupos de apoyo
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
use yii\helpers\ArrayHelper;

use app\models\TiposGruposSoporte;
use app\models\Sedes;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GruposSoporteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos Soportes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-soporte-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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

            // 'id',
            [
				'attribute'=>'id_tipo_grupos',
				'value' => function( $model )
				{
					$tiposGrupos = TiposGruposSoporte::findOne($model->id_tipo_grupos);
					return $tiposGrupos ? $tiposGrupos->descripcion : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(TiposGruposSoporte::find()->all(), 'id', 'descripcion' ),
				
			],
            'descripcion',
            [
				'attribute'=>'id_sede',
				'value' => function( $model )
				{
					$sedes = Sedes::findOne($model->id_sede);
					return $sedes ? $sedes->descripcion : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
				
			],
            [
				'attribute'=>'id_jornada_sede',
				'value' => function( $model )
				{
					/**
					* Llenar descripcion indicador desempeño
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand(" SELECT sj.id, j.descripcion
															FROM jornadas as j, sedes_jornadas as sj
															WHERE sj.id =$model->id_jornada_sede
															AND j.id = sj.id_jornadas
															");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            //'edad_minima',
            //'edad_maxima',
            //'cantidad_participantes',
            [
				'attribute'=>'id_docentes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre los docentes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("select d.id_perfiles_x_personas as id, concat(p.nombres,' ',p.apellidos) as nombres
												from personas as p, perfiles_x_personas as pp, docentes as d, perfiles as pe
												where p.id= pp.id_personas
												and p.estado=1
												and pp.id_perfiles=pe.id
												and pe.id=10
												and pe.estado=1
												and pp.id= d.id_perfiles_x_personas
												and d.id_perfiles_x_personas = $model->id_docentes
															");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			], 
            //'observaciones',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
