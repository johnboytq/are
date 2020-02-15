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

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipacionProyectosMaestro */

$this->title = 'Modificar: ';
$this->params['breadcrumbs'][] = ['label' => 'Participacion en proyectos de maestros', 'url' => ['index', 'idSedes' => $idSedes, 'idInstitucion' => $idInstitucion]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="participacion-proyectos-maestro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 			=> $model,
		'idSedes' 			=> $idSedes,
		'idInstitucion'		=> $idInstitucion,
		'instituciones'		=> $instituciones,
		'sedes' 			=> $sedes,
		'estados' 			=> $estados,
		'nombresProyectos' 	=> $nombresProyectos,
		'personas' 			=> $personas,
		'perfiles' 			=> $perfiles,
    ]) ?>

</div>
