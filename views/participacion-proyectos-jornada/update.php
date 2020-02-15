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
Fecha: 25-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de participacion proyectos jornada
---------------------------------------
Modificaciones:
Fecha: 25-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Miga de pan
pasara variables al form
---------------------------------------
**********/


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipacionProyectosJornada */

$this->title = $nombreInstitucion;
	
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Participacion Proyectos Jornada', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
				 ]
	];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="participacion-proyectos-jornada-update">

    <h1><?= Html::encode('Actualizar Participacion Proyectos Jornada:') ?></h1>

    <?= $this->render('_form', [
         'model' 		=> $model,
		'nombrePrograma'=> $nombrePrograma,
		'tipo'			=> $tipo,
		'nombreInstitucion'	=> $nombreInstitucion,
		'idInstitucion'	=> $idInstitucion,
		'estado'		=> $estado,
		
    ]) ?>

</div>
