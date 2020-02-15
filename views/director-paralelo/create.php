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
use app\models\Sedes;
use	yii\helpers\ArrayHelper;

$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];


/* @var $this yii\web\View */
/* @var $model app\models\DirectorParalelo */

$this->title = 'Agregar director de grupo';
$this->params['breadcrumbs'][] = [
								'label' => 'Asignaturas', 
								'url' => [
											'index',
											'idInstitucion' => $idInstitucion, 
											'idSedes' 		=> $idSedes,
										 ]
							 ];		
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="director-paralelo-create">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'idSedes' => $idSedes,
		'grupos'=>$grupos,
		'docentes'	=>$docentes
    ]) ?>

</div>
