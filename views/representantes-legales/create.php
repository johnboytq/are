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

$this->title = 'Agregar Estudiante';
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="representantes-legales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		// 'estudiantes'=>$estudiantes,
		// 'representantesLegales'=>$representantesLegales,
		// 'modelRepresentantesLegales'=> $modelRepresentantesLegales,
		'estudianteSelected'=>0,
		'representantesLegalesSelected'=>0,
    ]) ?>

</div>
