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
Fecha: 16-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de AsignaturasNivelesSedes
---------------------------------------
Modificaciones:
Modificaciones:
Fecha: 08-07-2018
Persona encargada: Edwin Molina
Cambios realizados: - Se revisa el titulo de los breadcrumbs
---------------------------------------
Fecha: 16-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Miga de pan
sale el nombre de la sede
texto boton a Agregar
---------------------------------------
**********/
use yii\helpers\Html;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Periodos */



$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];

$this->title = 'Agregar';
$this->params['breadcrumbs'][] = [
									'label' => 'Periodos', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periodos-create">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'idSedes'=>$idSedes,
		'estados'=>$estados,
    ]) ?>

</div>
