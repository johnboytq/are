<?php
/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 18-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se deja instición y sede según la SESSION
**********/


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

use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

use app\models\Estados;
use app\models\NombresProyectosParticipacion;
use app\models\Instituciones;
use app\models\Sedes;
use app\models\Personas;
use app\models\Perfiles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipacionProyectosMaestroBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participacion en proyectos de maestros';
$this->params['breadcrumbs'][] = $this->title;

$institucion = Instituciones::findOne($idInstitucion);
$sedes 		 = Sedes::findOne($idSedes);

?>
<div class="participacion-proyectos-maestro-index">

    <h1><?= Html::encode($institucion->descripcion) ?></h1>
    <h3><?= Html::encode($sedes->descripcion) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create','idSedes' => $idSedes, 'idInstitucion' => $idInstitucion ], ['class' => 'btn btn-success']) ?>
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
				'attribute' => 'programa_proyecto',
				'value' 	=> function( $model ){
					$nombreProyecto = NombresProyectosParticipacion::findOne( $model->programa_proyecto );
					return $nombreProyecto ? $nombreProyecto->descripcion : '';
				},
				
			],
            [ 
				'attribute' => 'participante',
				'value'		=> function( $model ){
					$persona = Personas::findOne( $model->participante );
					return $persona ? $persona->nombres." ".$persona->apellidos : '';
				}
			],
            [ 
				'attribute' => 'tipo',
				'value'		=> function( $model ){
					$perfil = Perfiles::findOne( $model->tipo );
					return $perfil ? $perfil->descripcion : '';
				},
			],
            'objeto',
            //'duracion',
            //'anio_inicio',
            //'anio_fin',
            //'tematica',
            //'areas',
            //'otros',
            //'materiales_recursos',
            //'logros',
            //'observaciones',
            //'id_institucion',
            //'estado',

            [
				'class' => 'yii\grid\ActionColumn',
				'buttons' => [
						'view' => function ($url,$model) {
							
								return Html::a(
												'<span class="glyphicon glyphicon-eye-open"></span>', 
												$url."&idSedes=".$_SESSION['sede'][0]."&idInstitucion=".$_SESSION['instituciones'][0]
											);
						},
						'update' => function ($url,$model) {
							
								return Html::a(
												'<span class="glyphicon glyphicon-pencil"></span>', 
												$url."&idSedes=".$_SESSION['sede'][0]."&idInstitucion=".$_SESSION['instituciones'][0]
											);
						},
						'delete' => function ($url,$model) {
							
								return Html::a(
												'<span class="glyphicon glyphicon-trash"></span>', 
												$url."&idSedes=".$_SESSION['sede'][0]."&idInstitucion=".$_SESSION['instituciones'][0],
												[
													'data-confirm'  => "¿Está seguro de eliminar este elemento?",
													'title' 		=> "Eliminar",
													'aria-label'	=> "Eliminar",
													'data-pjax'		=> "0",
													'data-method'	=> "post",
												]
											);
						},
				],
			],
        ],
    ]); ?>
</div>
