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
Desarrollador: Oscar David Lopez
Descripción: CRUD Director paralelo (grupo)
---------------------------------------
Modificaciones:
Fecha: 13-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio de dataGred a DataTables
titulo a Director de grupo
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;


use fedemotta\datatables\DataTables;
use app\models\personas;
use app\models\PerfilesXPersonas;
use app\models\Paralelos;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DirectorParaleloBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Director de grupo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="director-paralelo-index">

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
			[
				'attribute'=>'id_perfiles_x_personas_docentes',
				'value' => function( $model )
				{
					$id = PerfilesXPersonas::findOne($model->id_perfiles_x_personas_docentes);
					$personas = Personas::findOne($id);
					return $personas ? $personas->nombres." ".$personas->apellidos : '';
				}, 
			],	
			[
				'attribute'=>'id_paralelo',
				'value' => function( $model )
				{
					$paralelo = Paralelos::findOne($model->id_paralelo);
					return $paralelo ? $paralelo->descripcion : '';
				}, 
			],	
			
			
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
