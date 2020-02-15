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

use yii\helpers\Url;
use app\models\Instituciones;
use app\models\TiposDocumentos;

use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentosBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->registerJsFile("https://unpkg.com/sweetalert/dist/sweetalert.min.js");
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/documentos.js',['depends' => [\yii\web\JqueryAsset::className()]]);

if( isset($guardado) && $guardado == 1 ){
	echo Html::hiddenInput( 'guardado', '1' );
}

$this->title = 'Instancias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentos-index">

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

            // 'id',
            [ 
				'attribute' => 'ruta' ,
				'format' 	=> 'raw' ,
				'value'		=> function( $model ){
					return Html::a( "Ver archivo", Url::to( "@web/".$model->ruta , true), [ "target"=>"_blank" ] );
				},
			],
			[
				'attribute' => 'id_instituciones',
				'value' => function( $model ){
					$institucion = Instituciones::findOne( $model->id_instituciones );
					return $institucion ? $institucion->descripcion: '' ;
				},
			],
            [
				'attribute' => 'id_tipo_documentos',
				'value' 	=> function( $model ){
					
					$tipoDocumento = TiposDocumentos::findOne( $model->id_tipo_documentos );
					return $tipoDocumento ? $tipoDocumento->descripcion : '' ;
				},
			],

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
			],
        ],
    ]); ?>
</div>
