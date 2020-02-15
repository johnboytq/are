<?php

use yii\helpers\Html;
use yii\grid\GridView;

use fedemotta\datatables\DataTables;
use app\models\Personas;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProyectosPedagogicosTransversalesBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proyectos Pedagogicos Transversales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyectos-pedagogicos-transversales-index">

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

            'id',
            'codigo_grupo',
            'nombre_grupo',
			[
				'attribute' => 'coordinador',
				'value' 	=> function( $model ){
					$persona = Personas::findOne( $model->coordinador );
					return $persona ? $persona->nombres.' '.$persona->apellidos : '' ;
				},
			],
            'area',
            //'correo',
            //'celular',
            //'linea_investigacion_1',
            //'linea_investigacion_2',
            //'linea_investigacion_3',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
