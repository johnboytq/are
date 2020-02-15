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

use yii\helpers\Html;
use yii\grid\GridView;

use fedemotta\datatables\DataTables;

use app\models\NombresProyectosParticipacion;
use app\models\Instituciones;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParticipacionProyectosIEBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participacion Proyectos IE';
$this->params['breadcrumbs'][] = $this->title;

$institucion = Instituciones::findOne( $idInstitucion );
?>
<div class="participacion-proyectos-ie-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= Html::encode($institucion->descripcion) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create', 'idInstitucion' => $idInstitucion ], ['class' => 'btn btn-success']) ?>
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
				'value' => function( $model ){
					$nombreProyecto = NombresProyectosParticipacion::findOne( $model->programa_proyecto );
					return $nombreProyecto ? $nombreProyecto->descripcion: '' ;
				}, 
			],
            'participacion:boolean',
            'operador',
            'entidad_financia',
            //'objetivo',
            //'duracion',
            //'anio_inicio',
            //'anio_finalizacion',
            //'tematica',
            //'areas',
            //'sedes',
            //'numero_docentes',
            //'numero_estudiantes',
            //'numero_padres',
            //'numero_directivos',
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
