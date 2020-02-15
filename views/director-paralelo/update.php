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

/**********
Versión: 001
Fecha: 13-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Director paralelo (grupo)
---------------------------------------
Modificaciones:
Fecha: 13-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - miga de pan
envio de variables a la vista
---------------------------------------
**********/

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DirectorParalelo */

use app\models\Sedes;
use	yii\helpers\ArrayHelper;

$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];


$this->title = 'Actualizar Director de grupo';
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Director de grupo', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
					'idSedes' 		=> $idSedes,
				 ]
	];	
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="director-paralelo-update">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
			'idSedes'	=> $idSedes,
			'idInstitucion'=>$idInstitucion,
			'grupos'	=>$grupos,
			'docentes'	=>$docentes
    ]) ?>

</div>
