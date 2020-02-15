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
Fecha: 24-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de participacion proyectos jornada
---------------------------------------
Modificaciones:
Fecha: 24-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - datagrid a datatables
nombres de los botones
nombre correspondientes a los ids
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
use app\models\NombresProyectosParticipacion;
use app\models\Personas;
use app\models\Perfiles;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipacionProyectosJornadaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $nombreInstitucion;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participacion-proyectos-jornada-index">

    <h1><?= Html::encode('Participacion Proyectos Jornadas') ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', [
									'create',
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
				'attribute'=>'nombre_programa',
				'value' => function( $model )
				{
					$nombrePrograma= NombresProyectosParticipacion::findOne($model->nombre_programa);
					return $nombrePrograma ? $nombrePrograma->descripcion : '';
				}, //para buscar por el nombre
				
			],	
			[
				'attribute'=>'nombre_participante',
				'value' => function( $model )
				{
					$nombrePersona= Personas::findOne($model->nombre_participante);
					return $nombrePersona ? $nombrePersona->nombres." ".$nombrePersona->apellidos : '';
				}, //para buscar por el nombre
				
			],
			[
				'attribute'=>'tipo',
				'value' => function( $model )
				{
					$perfil= Perfiles::findOne($model->tipo);
					return $perfil ? $perfil->descripcion: '';
				}, //para buscar por el nombre
				
			],
            'objetivo',
            //'duracion',
            //'ano_inicio',
            //'ano_fin',
            //'tematica',
            //'areas',
            //'otros',
            //'materiales_recursos',
            //'logros',
            //'observaciones',
            //'id_institucion',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
