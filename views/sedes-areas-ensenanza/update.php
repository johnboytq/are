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
/* @var $model app\models\SedesAreasEnsenanza */

$this->title = 'Modificar';
$this->params['breadcrumbs'][] = [
									'label' => 'Especialidad', 
									'url' => [
												'index',
												'idInstitucion' => $modelInstitucion->id,
												'idSedes' 		=> $modelSedes->id,
											]
								];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="sedes-areas-ensenanza-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'sedes' => $sedes,
        'areas'	=> $areas,
    ]) ?>

</div>
