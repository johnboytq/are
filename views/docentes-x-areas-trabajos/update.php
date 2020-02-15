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
/* @var $model app\models\DocentesXAreasTrabajos */

$this->title = 'Modificar áreas de trabajo:';
$this->params['breadcrumbs'][] = ['label' => 'Docentes por áreas de trabajo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_perfiles_x_personas_docentes, 'url' => ['view', 'id_perfiles_x_personas_docentes' => $model->id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $model->id_areas_trabajos]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docentes-xareas-trabajos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
		'personas' 		=> $personas,
        'areasTrabajo' 	=> $areasTrabajo,
    ]) ?>

</div>
