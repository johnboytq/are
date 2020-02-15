<?php
/**********
Versión: 001
Fecha: 06-03-2018
Desarrollador: Oscar David lopez
Descripción: CRUD de Apoyo Académico
---------------------------------------
Fecha: 18-06-2018
Modificaciones: Listado de todos los estudiantes de la sede
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apoyo académico';
$this->params['breadcrumbs'][] = $this->title;
$idSedes = $_SESSION['sede'][0];
$sql ="
		SELECT es.id_perfiles_x_personas as id, pe.nombres,pe.apellidos, pe.identificacion
FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe, 
perfiles_x_personas_institucion ppi, paralelos as pa, sedes_jornadas as sj
WHERE es.id_perfiles_x_personas = pp.id
AND pp.id_personas = pe.id
AND pp.id_perfiles = 11
AND ppi.id_perfiles_x_persona = pp.id
and pa.id = es.id_paralelos
and pa.id_sedes_jornadas = sj.id
and sj.id_sedes = $idSedes
group by es.id_perfiles_x_personas,pe.nombres,pe.apellidos, pe.identificacion
			 
		   ";		
		$dataProvider = new SqlDataProvider([
				'sql' => $sql,
				
			]);
				
// $dataProvider->query->andWhere('id_sede='.$idSedes);
// $dataProvider->query->andWhere('estado=1');

?>
<div class="sedes-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
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
            'nombres',
            'apellidos',
			'identificacion',
            
            [
			'class' => 'yii\grid\ActionColumn',
			'template'=>'{view}',
			'urlCreator' => function ($action, $model, $key, $index) 
			{
				
				if ($action === 'view') {
					$url ="index.php?r=apoyo-academico/index&idEstudiante=".$model['id'];
					return $url;
				}
				
			}
			
			],
        ],
    ]); ?>
	
</div>