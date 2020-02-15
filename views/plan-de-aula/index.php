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
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;


use app\models\Personas;
use app\models\Periodos;
use app\models\Niveles;
use app\models\Asignaturas;
use yii\helpers\ArrayHelper;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PlanDeAulaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Plan de aulas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-de-aula-index">

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

            [
				'attribute' => 'id_periodo',
				'value' 	=> function($model){
									$periodo = Periodos::find()->where( 'id='.$model->id_periodo )->one();
									return $periodo ? $periodo->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map( Periodos::find()->all(), 'id', 'descripcion' ),
			],
			[
				'attribute' => 'id_nivel',
				'value' 	=> function($model){
									$nivel = Niveles::find()->where( 'id='.$model->id_nivel )->one();
									return $nivel ? $nivel->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map( Niveles::find()->all(), 'id', 'descripcion' ),
			],
			[
				'attribute' => 'id_asignatura',
				'value' 	=> function($model){
									$nivel = Asignaturas::find()->where( 'id='.$model->id_asignatura )->one();
									return $nivel ? $nivel->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map( Asignaturas::find()->all(), 'id', 'descripcion' ),
			],
            'fecha',
            //'actividad',
            //'observaciones',
            //'evaluativa:boolean',
            //'estado',
			//'id_indicador_desempeno', 
			//'cognitivo_conocer:boolean', 
			//'cognitivo_hacer:boolean', 
			//'cognitivo_ser:boolean', 
			//'personal:boolean', 
			//'social:boolean', 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
