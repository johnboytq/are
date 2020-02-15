<?php

use yii\helpers\Html;

use fedemotta\datatables\DataTables;
use yii\grid\GridView;

use app\models\PerfilesXPersonas;
use app\models\Personas;
use app\models\Instituciones;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GestionCurricularBitacorasVisitasIeoBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = "bitacoras-visitas";
?>
<div class="gestion-curricular-bitacoras-visitas-ieo-index">

    <h1><?= Html::encode('Bitácora De Visitas A Las Instituciones Educativas Oficiales') ?></h1>
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

            'fecha_inicio',
            'fecha_fin',
			[
				'attribute'=>'id_persona_docente_tutor',
				'value' => function( $model )
				{
					$id = PerfilesXPersonas::findOne($model->id_persona_docente_tutor);
					$personas = Personas::findOne($id);
					return $personas ? $personas->nombres." ".$personas->apellidos : '';
				}, 
			],	
			[
				'attribute'=>'id_institucion',
				'value' => function( $model )
				{
					$institucion = Instituciones::findOne($model->id_institucion);
					return $institucion ? $institucion->descripcion : '';
				}, 
			],
            // 'id_sede',
            //'id_jornada',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
