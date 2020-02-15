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


// print_r($_SESSION);

// die;

/**********
Versión: 001
Fecha: (16-03-2018)
Desarrollador: Viviana Rodas
Descripción: Lista de distribuiones academicas
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribucionesAcademicasBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distribuciones Académicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribuciones-academicas-index">

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
				'attribute'=>'id_asignaturas_x_niveles_sedes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre asignatura por id asignaturas niveles sedes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT a.descripcion
															FROM asignaturas as a, asignaturas_x_niveles_sedes as ans
															WHERE ans.id_asignaturas = a.id
															AND ans.id = $model->id_asignaturas_x_niveles_sedes;");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            [
				'attribute'=>'id_perfiles_x_personas_docentes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre del docente
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("select concat(p.nombres,' ',p.apellidos) as nombres
															from personas as p, perfiles_x_personas as pp, docentes as d, distribuciones_academicas as da
															where p.id= pp.id_personas
															and p.estado=1
															and da.id_perfiles_x_personas_docentes = d.id_perfiles_x_personas
															and d.id_perfiles_x_personas = pp.id
															and pp.id_personas = p.id
															and d.id_perfiles_x_personas = $model->id_perfiles_x_personas_docentes;
															");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			], 
            [
				'attribute'=>'id_paralelo_sede',
				'value' => function( $model )
				{
					/**
					* Llenar la descripcion del paralelo
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand(" select p.descripcion
															from paralelos as p, distribuciones_academicas as da
															where da.id_paralelo_sede = p.id
															and id_paralelo_sede = $model->id_paralelo_sede
															and p.estado = 1
															");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            // 'fecha_ingreso',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
