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
Fecha: (06-03-2018)
Desarrollador: Viviana Rodas
Descripción: Vista de personas
---------------------------------------
Modificaciones:
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
*/

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Generos;
use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonasBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

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
			"ajax" => [
				"url"	=> Yii::$app->getUrlManager()->createUrl('personas/consultar-personas'),
				"type"	=> "GET",
			],
			"processing" => true,
			"serverSide"=> true,
		],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'usuario',
            // 'psw',
            'identificacion',
            'nombres',
            'apellidos',
            //'telefonos',
            //'fecha_nacimiento',
            //'fecha_registro',
            'correo',
            //'domicilio',
            //'fecha_ultimo_ingreso',
            //'envio_correo:boolean',
            //'id_municipios',
            //'id_tipos_identificaciones',
            //'latitud',
            //'longitud',
            //'id_estados_civiles',
			//este es el llamado al modelo generos para poder listar la descricion del genero
            // [
				// 'attribute'=>'id_generos',
				// 'value' => function( $model )
				// {
					// $descripcionGeneros = Generos::findOne($model->id_generos);
					// return $descripcionGeneros ? $descripcionGeneros->descripcion : '';
				// },
				
			// ], 
            //'hobbies',
            //'id_barrios_veredas',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
