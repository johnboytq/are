<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\helpers\Url;

use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProyectoAulaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proyecto Aulas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyecto-aula-index">

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

            'id_grupo',
            'nombre_proyecto',
            'id_jornada',
            'id_persona_coordinador',
            'correo',
			 [ 
				'attribute' => 'ruta' ,
				'format' 	=> 'raw' ,
				'value'		=> function( $model ){
					
					if( $model->archivo ){
						return Html::a( "Ver archivo", Url::to( "@web/".$model->archivo , true), [ "target"=>"_blank" ] );
					}
					else{
						return 'Sin documento asociado';
					}
				},
			],
            //'celular',
            //'descripcion',
            //'avance_1',
            //'avance_2',
            //'avance_3',
            //'avance_4',
            //'Id_sede',
            //'id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
