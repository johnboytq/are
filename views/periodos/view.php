<?php

/**********
Versión: 001
Fecha: 06-03-2018
---------------------------------------
Modificaciones:
Fecha: 08-07-2018
Persona encargada: Edwin Molina
Cambios realizados: - Se revisa el titulo de los breadcrumbs
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
/**********
Versión: 001
Fecha: 17-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de AsignaturasNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 17-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio nombre botones
Cambio en los datos en la forma que se muestran
Cambio mensaje de confirmacion al borra un elemento
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Sedes;
use	yii\helpers\ArrayHelper; 
/* @var $this yii\web\View */
/* @var $model app\models\Periodos */

// id de la sede miga de pan 
$idSedes = $model->id_sedes;
//nombre de la sede para el titulo
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
//id institucion miga de pan
$idInstitucion = ArrayHelper::getColumn($nombreSede,'id_instituciones');
$idInstitucion = $idInstitucion[0];
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = [
									'label' => 'Periodo', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sedes,
											 ]
								 ];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodos-view">

    <h1><?= Html::encode($nombreSede) ?></h1>

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
            'fecha_inicio',
            'fecha_fin',
        ],
    ]) ?>

</div>
