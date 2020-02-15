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

$this->title = 'Agregar docente por áreas  de trabajo:';
$this->params['breadcrumbs'][] = ['label' => 'Docente por áreas  de trabajo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentes-xareas-trabajos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
		'personas' 		=> $personas,
        'areasTrabajo' 	=> $areasTrabajo,
    ]) ?>

</div>
