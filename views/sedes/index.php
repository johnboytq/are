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
Fecha: 02-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se crea buscador
---------------------------------------
Fecha: 07-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se quita columna ID
---------------------------------------
Fecha: 02-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se envía la vista _form los municipios y el id de la institución seleccionada desde la lista de sedes 
					y a la url del breadcrumbs también
---------------------------------------
Fecha: 05-04-2018
Persona encargada: Viviana Rodas
Cambios realizados: Se agregan los datatables
---------------------------------------
**********/

use yii\helpers\Html;
use yii\helpers\URL;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Instituciones;

$descripcionIntitucion = "";
if( !empty( $idInstitucion ) )
{
	$insti = Instituciones::findOne($idInstitucion);
	$descripcionIntitucion = $insti->descripcion."\n";
}

$this->title = 'Sedes';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sedes-index">
    
	<h1><?= Html::encode($descripcionIntitucion) ?></h1>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Agregar', ['create', 'idInstitucion'=>$idInstitucion ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
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
            'descripcion',
            'telefonos',
            'direccion',
            // 'area',
            //'id_instituciones',
            //'latitud',
            //'longitud',
            //'id_zonificaciones',
            //'id_tenencias',
            //'id_modalidades',
            //'id_municipios',
            //'id_generos_sedes',
            //'id_calendarios',
            //'id_estratos',
            //'id_barrios_veredas',
            'codigo_dane',
            //'sede_principal',
            //'comuna',
            //'estado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
