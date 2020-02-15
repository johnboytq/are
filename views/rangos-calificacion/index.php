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
Fecha: 13-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de RangosCalificacion
---------------------------------------
Modificaciones:
Fecha: 13-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - No se muestra el id, no el estado
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
**********/

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Instituciones;
use app\models\TiposCalificacion;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

$institucionNombre = new Instituciones();
$institucionNombre = $institucionNombre->find()->where('id='.$idInstitucion)->all();
$institucionNombre = ArrayHelper::map($institucionNombre,'id','descripcion');
$institucionNombre = $institucionNombre[$idInstitucion];

/* @var $this yii\web\View */
/* @var $searchModel app\models\RangosCalificacionBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $institucionNombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rangos-calificacion-index">

    <h1><?= Html::encode('Rangos Calificaciones') ?></h1>
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

            'valor_minimo',
            'valor_maximo',
            'descripcion',
            [
				'attribute'=>'id_tipo_calificacion',
				'value'=> function ($model)
				{
					$TipoCalificacion = TiposCalificacion::findOne($model->id_tipo_calificacion);
					return $TipoCalificacion ? $TipoCalificacion->descripcion : '';
				},
			],
            //'id_instituciones',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
