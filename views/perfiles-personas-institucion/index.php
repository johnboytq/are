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
Fecha: (26-03-2018)
Desarrollador: Viviana Rodas
Descripción: index lista de perfiles persona institucion
--------
*/

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerfilesPersonasInstitucionBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Perfiles Personas Instituciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfiles-personas-institucion-index">

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

            // 'id',
            [
				'attribute'=>'id_perfiles_x_persona',
				'value' => function( $model )
				{
					/**
					* Llenar nombre personas por perfil
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT pp.id, concat(p.nombres,' ',p.apellidos,' - ',pe.descripcion) as nombres
														FROM public.perfiles_x_personas as pp, personas as p, perfiles as pe, perfiles_x_personas_institucion as ppi
														WHERE pp.id = $model->id_perfiles_x_persona
														AND p.id = pp.id_personas
														AND pe.id = pp.id_perfiles
														AND pp.estado = 1
														AND p.estado = 1
														AND pe.estado = 1
														AND ppi.id_perfiles_x_persona = pp.id
					");
					$result = $command->queryAll();
								
					return @$result[0]['nombres'];
				},
				
			], 
			[
				'attribute'=>'id_institucion',
				'value' => function( $model )
				{
					/**
					* Llenar las instituciones
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT i.id, i.descripcion
														FROM public.instituciones as i, perfiles_x_personas_institucion as ppi
														where i.estado = 1
														AND ppi.id_institucion = i.id
														AND ppi.id_institucion = $model->id_institucion
														AND ppi.estado = 1
					");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            // 'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
