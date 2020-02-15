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
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se envía a la vista form el id de la sede y de la institución
					- Al breadcrumbs le agrego también el id de la sede y la institución
---------------------------------------
**********/

use yii\helpers\Html;

use app\models\Sedes;


/* @var $this yii\web\View */
/* @var $model app\models\SedesJornadas */

$modelSedes = Sedes::findOne($model->id_sedes);

$this->title = 'Agregar Jornada:';
$this->params['breadcrumbs'][] = [
									'label'	=> 'Sedes Jornadas', 
									'url' 	=> [
													'index', 
													'idInstitucion' => $idInstitucion, 	//llega del controlador (actionCreate)
													'idSedes' 		=> $idSedes,		//llega del controlador (actionCreate)
												]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-jornadas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
        'sedes' 		=> $sedes,
        'jornadas' 		=> $jornadas,
		'idSedes' 		=> $idSedes,		//llega del controlador (actionCreate)
		'idInstitucion' => $idInstitucion,	//llega del controlador (actionCreate)
    ]) ?>

</div>
