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

/* @var $this yii\web\View */
/* @var $model app\models\SedesJornadas */

use app\models\Sedes;

//Creo modelo sedes para poder encontrar el id de instituciones
$modelSedes = Sedes::findOne($model->id_sedes);

$this->title = 'Actualizar jornada:';
$this->params['breadcrumbs'][] = [
									'label' => 'Sedes Jornadas', 
									'url' 	=> [
													'index',
													'idInstitucion' => $modelSedes->id_instituciones,
													'idSedes' 		=> $modelSedes->id,
												]
								 ];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sedes-jornadas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
        'sedes' 		=> $sedes,
        'jornadas' 		=> $jornadas,
        'idSedes' 		=> $modelSedes->id,
        'idInstitucion'	=> $modelSedes->id_instituciones,
    ]) ?>

</div>
