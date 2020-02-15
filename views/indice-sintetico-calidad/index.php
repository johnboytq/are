<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Estados;
use app\models\IndiceEspecifico;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\IndiceSinteticoCalidadBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Indice Sintético de Calidad';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indice-sintetico-calidad-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
			'dataProvider' => $dataProvider,
			'filterModel'  => $searchModel,
			'clientOptions' => [
			'language'=>[
							'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
						],
			"lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
			"info"		=>false,
			"responsive"=>true,
			"dom"		=> 'lfTrtip',
			"tableTools"=>[
				 "aButtons"=> [
					[
					"sExtends"=> "xls",
					"oSelectorOpts"=> ["page"=> 'current']
					],
					[
					"sExtends"=> "pdf",
					"oSelectorOpts"=> ["page"=> 'current']
					],
				],
			 ],
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
            'anio',
            [
				'attribute' => 'id_indice_especifico',
				'value'		=>  function( $model ){
					$indice = IndiceEspecifico::findOne( $model->id_indice_especifico );
					return $indice ? $indice->descripcion : '';
				}
			],
			'valor',
            [
				'attribute' => 'estado',
				'value' 	=> function( $model ){
					$estado = Estados::findOne( $model->estado );
					return $estado ? $estado->descripcion : '';
				},
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
