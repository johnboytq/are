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
Fecha: 21-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de infraestructura educativa
--------------------------------------
Modificaciones:
Fecha: 21-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: Se ponene datatables
---------------------------------------
**********/


use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;
use app\models\Sedes;
use app\models\Instituciones;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$nombreInstitucion = Instituciones::find()->where(['id' => $idInstitucion])->one();
$nombreInstitucion = $nombreInstitucion->descripcion;

$this->title = $nombreInstitucion;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="infraestructura-educativa-index">

    <h1><?= Html::encode('Infraestructura Educativa') ?></h1>

    <p>
	<?= Html::a('Agregar', [
									'create',
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
				'attribute'=>'id_sede',
				'value' => function( $model )
				{
					$sede = Sedes::findOne($model->id_sede);
					return $sede ? $sede->descripcion : '';
				},
			],
            'objeto_intervencion:boolean',
            'intervencion_infraestructura',
            'alcance_intervencion',
            //'presupuesto',
            //'cumplimiento_pedido',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
