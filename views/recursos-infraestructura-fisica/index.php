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

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\RecursosInfraestructuraFisica;
use fedemotta\datatables\DataTables;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecursosInfraestructuraFisicaBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$model = new RecursosInfraestructuraFisica();
// $idSedes = $model->id_sede;
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
// $idInstitucion = ArrayHelper::map($nombreSede,'id','id_instituciones');
// $idInstitucion = $idInstitucion[$idSedes];

$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$this->title = 'Recursos Infraestructuras Físicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recursos-infraestructura-fisica-index">

    <h1><?= Html::encode($nombreSede) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?= Html::a('Agregar', [
									'create',
									'idSedes' 		=> $idSedes,
									'idInstitucion' => $idInstitucion, 
								], 
								['class' => 'btn btn-success'
		]) ?>

    </p>

    <?=  DataTables::widget([
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
            'cantidad_aulas_regulares',
            'cantidad_aulas_multiples',
            'cantidad_oficinas_admin',
            'cantidad_aulas_profesores',
            'cantidad_espacios_deportivos',
            'cantidad_baterias_sanitarias',
            'cantidad_laboratorios',
            // 'cantidad_portatiles',
            // 'cantidad_computadores',
            // 'cantidad_tabletas',
            // 'cantidad_bibliotecas_salas_lectura',
            // 'programas_informaticos_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
