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
Fecha: 17-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Aponderacion-resultados
---------------------------------------
Modificaciones:
Fecha: 17-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se elimina el campo id para mostrar
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
Modificaciones:
Fecha: 27-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se agrega el seleccionar la sede y la institucion
---------------------------------------
**********/
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Periodos;
use	yii\helpers\ArrayHelper;
use app\models\PonderacionResultados;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PonderacionResultadosBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ponderación Resultados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ponderacion-resultados-index">

    <h1><?= Html::encode($this->title) ?></h1>
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
				'attribute'=>'id_periodo',
				'value' => function( $model )
				{
					$Periodos = Periodos::findOne($model->id_periodo);
					return $Periodos ? $Periodos->descripcion : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(Periodos::find()->all(), 'id', 'descripcion' ),
				
			],
			[
				'attribute'=>'calificacion',
				//para buscar por el nombre
				'filter' 	=> ArrayHelper::map(PonderacionResultados::find()->all(), 'calificacion', 'calificacion' ),
				
			],			

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
