<?php

/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 26-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se muestra la sede
---------------------------------------
**********/

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
use fedemotta\datatables\DataTables;
use app\models\Instituciones;

$nombreInstitucion = Instituciones::find()->where("id=".$idInstitucion)->one();
$nombreInstitucion = $nombreInstitucion->descripcion;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docente por Institucion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docente-institucion-index">

    <h1><?= Html::encode($nombreInstitucion) ?></h1>

	<?php $dataProvider->getCount() < 1 ? '<h1>NO HAY REGISTROS PARA MOSTRAR</h1>' : '' ?>
	
	   <?= DataTables::widget([
			'dataProvider' => $dataProvider,
			'clientOptions' => [
				'language'=>[
						'url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json',
						"sEmptyTable" => "No hay información",
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
				'identificacion',
				'nombres',
				'apellidos',
				'asignatura',
				'sede',
				

				// ['class' => 'yii\grid\ActionColumn'],
			],
		]); ?>
</div>
