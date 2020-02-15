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
/* @var $model app\models\DistribucionesAcademicas */

$this->title = 'Modificar: ';
$this->params['breadcrumbs'][] = [
									'label' => 'Distribuciones Académicas', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
								 
$this->params['breadcrumbs'][] = $this->title;
// $this->params['breadcrumbs'][] = ['label' => 'Distribuciones Academicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

?>
<div class="distribuciones-academicas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'estados'=>$estados,
		'idSedes' => $idSedes,
		'docentes'=>$docentes,
		'aulas'=>$aulas,
		'niveles_sede'=>$niveles_sede,
		'asignaturas_distribucion'=>$asignaturas_distribucion,
		'modificar'=>$modificar,
		'idInstitucion' => $idInstitucion,
		'paralelos_distribucion'=>$paralelos_distribucion,
		'dataProvider'=>$dataProvider,
		'nivelSelected'=>$nivelSelected,
    ]) ?>

</div>
