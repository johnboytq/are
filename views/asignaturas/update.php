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
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo AREAS DE ENSEÑANZA al CRUD
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Modificacion miga de pan
---------------------------------------
**********/
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */

$this->title = 'Update Asignaturas: ';
use app\models\Estados;
use app\models\Sedes;

//datos para la miga de pan
$sede = new Sedes();
$sede = $sede->find()->where('id='.$model->id_sedes)->all();
$sede = ArrayHelper::map($sede,'descripcion','id_instituciones');
$nombreSede = key($sede);

$idInstitucion = $sede[$nombreSede];
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
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="asignaturas-update">
<!--muestra como titulo la descripcion de la asignatura -->
    <h1><?= Html::encode("Asignaturas") ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
		'estados'	=> $estados,
		'sedes'		=> $sedes,
		'areas'		=> $areas,
    ]) ?>

</div>
