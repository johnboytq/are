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
Fecha: 14-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (estudiantes)
---------------------------------------
Modificaciones:
Fecha: 14-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - dataGrid a DataTables
nombres botones
Se oculta el campo id
Se muestra el nombre y apellidos de la persona en ambos campos
---------------------------------------
echa: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los botones, idioma a datatables
---------------------------------------
**********/
use yii\helpers\Html;
use yii\grid\GridView;
use	yii\helpers\ArrayHelper;

use app\models\Personas;
use	app\models\PerfilesXPersonas;
use fedemotta\datatables\DataTables;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RepresentantesLegalesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estudiantes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="representantes-legales-index">

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
			[
				'attribute'=>'id_perfiles_x_personas',
				'value' => function( $model )
				{
					/**
					* Llenar el nombre de los estudiantes
					*/
					//variable con la conexion a la base de datos 
					// print_r($model); die;
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("
					SELECT
						pp.id, 
						concat(p.nombres,' ',p.apellidos) as nombres
					FROM 
						public.perfiles_x_personas as pp, 
						personas as p, 
						representantes_legales as rl, 
						estudiantes as e
					WHERE 
						p.id = pp.id_personas
					AND 
						rl.id_perfiles_x_personas = pp.id
					AND 
						e.id_perfiles_x_personas = pp.id
					AND 
						p.estado = 1
					AND 
						pp.estado = 1
					AND 
						pp.id =". $model->id_perfiles_x_personas."");
					
					
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			],
			[
				'attribute'=>'id_personas',
				'value' => function( $model )
				{
					/**
					* Llenar el nombre de los representantes legales
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT p.id, concat(p.nombres,' ',p.apellidos) as nombres
															FROM public.perfiles_x_personas as pp, personas as p, representantes_legales as rl
															WHERE p.id = pp.id_personas
															AND rl.id_personas = p.id
															and p.estado = 1
															and pp.estado = 1
															AND p.id  = $model->id_personas
															group by p.id, p.nombres,p.apellidos");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			],
			
			
			
            ['class' => 'yii\grid\ActionColumn'],
        ]
    ]); ?>
</div>
