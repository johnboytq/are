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
/* @var $model app\models\RepresentantesLegales */

$this->title = 'Actualizar Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="representantes-legales-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model'						=> $model,
		'estudiantes'				=> $estudiantes,
		'representantesLegales'		=> $representantesLegales,
		// 'modelRepresentantesLegales'=> $modelRepresentantesLegales,
    ]) ?>

</div>
