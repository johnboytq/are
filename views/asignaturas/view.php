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
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo AREAS DE ENSEÑANZA al CRUD
---------------------------------------
Modificaciones:
Fecha: 10-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio en el campo estado para que muestre la descripcion del estado
Cambio en el campo id_sedes para que muestre la descripcion de la sede
cambio en el titulo para que muestre la sede
cambio en la miga de pan
cambio a los nombre de los botones
Cambio en el texto de confirmacion al borrar el elemento

---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

use app\models\Estados;
use app\models\Sedes;
use app\models\AreasEnsenanza;

//datos para la miga de pan
$sedes = new Sedes();
$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
$sedes = ArrayHelper::map($sedes,'descripcion','id_instituciones');
$nombreSede = key($sedes);

$idInstitucion = $sedes[$nombreSede];
/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */

$this->title = $nombreSede;
$this->params['breadcrumbs'][] = [
									'label' => 'Asignaturas', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="asignaturas-view">

    <h1><?= Html::encode('Asignaturas')?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descripcion',
			[
				'attribute' => 'id_areas_ensenanza',
				'value'		=> function( $model ){
									$areas = AreasEnsenanza::findOne( $model->id_areas_ensenanza );
									return $areas ? $areas->descripcion: '';
							   },
			],
			[
				'attribute'=> 'estado',
				//se muestra la descripcion del estado
				'value'=>function ($model)
				{
					$Estados = Estados::findOne($model->estado);
					return $Estados ? $Estados->descripcion : '';
					
				}
			],

			
        ],
    ]) ?>

</div>
