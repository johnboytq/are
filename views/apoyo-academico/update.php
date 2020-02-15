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

$nombreSede = Sedes::find()->where(['id' => $model->id_sede])->one();
$nombreSede = $nombreSede->descripcion;

/* @var $this yii\web\View */
/* @var $model app\models\ApoyoAcademico */

$this->title = 'Actualizar Apoyo Académico';
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Apoyo Academico', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
					'idSedes' 		=> $idSedes,
					'AAcademico'	=> $AAcademico,
				 ]
	];	
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apoyo-academico-update">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <?= $this->render('_form', [
        'model' 		=> $model,
		'estudiantes'	=> $estudiantes,
		'doctores' 		=> $doctores,
		'idSedes' 		=> $idSedes,
		'idInstitucion' => $idInstitucion,
		'AAcademico'	=> $AAcademico,
    ]) ?>

</div>
