<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Instituciones;
use app\models\AsignaturaEspecifica;
use app\models\AsignaturasEvaluadas;
use app\models\Estados;
use yii\helpers\ArrayHelper;

use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultadosPruebasSaberCaliBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultados-pruebas-saber-cali-index">

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

            [
				'attribute' => 'id_institucion',
				'value'	 	=> function( $model ){
					$institucion = Instituciones::findOne( $model->id_institucion );
					return $institucion ? $institucion->descripcion : '' ;
				}
			],
            'anio',
            [
				'attribute' => 'id_asignatura_especifica',
				'value'		=> function( $model ){
					$asignatura = AsignaturaEspecifica::findOne( $model->id_asignatura_especifica );
					return $asignatura ? $asignatura->descripcion : '' ;
				}
			],
			'valor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
