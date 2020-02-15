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
use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HorarioEstudianteBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="horario-estudiante-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
	
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/horarioEstudiante.js',['depends' => [\yii\web\JqueryAsset::className()]]);
	
	$form = ActiveForm::begin(); ?>
	
	
	<?= Html::tag('label', "<h2>Horario</h2>", ['id' => 'tablaModulosLabel']) ?>
    <?php ActiveForm::end(); ?> 

    

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
			
			'BLOQUE',
			'LUNES',
			'MARTES',
			'MIERCOLES',
			'JUEVES',
			'VIERNES',
			'SABADO',
			'DOMINGO',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	
</div>
