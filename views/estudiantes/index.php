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
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/
use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $searchModel app\models\EstudiantesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Sedes;
use	yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$this->title = 'Matricular Estudiante';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudiantes-index">

    <h1><?= Html::encode($nombreSede) ?></h1>
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
	
	
    <?php 
	echo DataTables::widget([
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
					* Llenar nombre del docente
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("
					SELECT es.id_perfiles_x_personas, concat(pe.nombres,' ',pe.apellidos) as nombres
					FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe
					where es.id_perfiles_x_personas = pp.id
					and pp.id_personas = pe.id
					and es.id_perfiles_x_personas =$model->id_perfiles_x_personas
					");
					$result = $command->queryAll();
					
					return $result[0]['nombres'];
				},
				
			],
			
			[
				'attribute'=>'id_paralelos',
				'value' => function( $model )
				{
					$paralelos = $model->paralelos;
					return $paralelos ? $paralelos->descripcion : '';
				}, //para buscar por el nombre
				
			],
			

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
