<?php

use yii\helpers\Html;

use fedemotta\datatables\DataTables;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EjecucionFaseIBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ejecucion Fases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejecucion-fase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Agregar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

            'id',
            'id_fase',
            'id_datos_sesiones',
            'docente',
            'asignaturas',
            //'especiaidad',
            //'paricipacion_sesiones',
            //'numero_apps',
            //'seiones_empleadas',
            //'acciones_realiadas',
            //'temas_problama',
            //'tipo_conpetencias',
            //'observaciones',
            //'id_datos_ieo_profesional',
            //'estado',
            //'numero_sesiones_docente',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
