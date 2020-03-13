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
/* @var $model app\models\Estudiantes */
use	yii\helpers\ArrayHelper;
use app\models\Sedes;
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$this->title = 'Agregar';
	$this->params['breadcrumbs'][] = [
									'label' => 'Matricular Estudiante', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];						 
								 
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="estudiantes-create">

    <h1><?= Html::encode($nombreSede) ?></h1>

	
	
    <?= $this->render('_form', [
        'model' => $model,
		// 'estudiantes'=>$estudiantes,
		'idSedes'=>$idSedes,	
		'niveles_sede'=>'',
		'estados'=>$estados,
		'paralelos'=>'',
		
    ]) ?>

</div>
