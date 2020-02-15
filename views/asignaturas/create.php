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
Cambios realizados: - Cambio en la miga de pan y envio de variables al _form
---------------------------------------
**********/
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use app\models\Estados;
use app\models\Sedes;

//datos para la miga de pan
$sede = new Sedes();
$sede = $sede->find()->where('id='.$idSedes)->all();
$sede = ArrayHelper::map($sede,'descripcion','id_instituciones');
$nombreSede = key($sede);

$idInstitucion = $sede[$nombreSede];


/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */

$this->title = 'Agregar';
$this->params['breadcrumbs'][] = [
									'label' => 'Asignaturas', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
		'estados'	=> $estados,
		'sedes'		=> $sedes,
		'areas'		=> $areas,
    ]) ?>

</div>
