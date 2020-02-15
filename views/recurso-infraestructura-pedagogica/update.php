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
Fecha: 09-04-2018
Persona encargada: Edwin Molina Grisales
CRUD de RECURSOS DE INFRAESTRUCTURA PEDAGOGICA
---------------------------------------
**********/

use yii\helpers\Html;

use	yii\helpers\ArrayHelper;
use app\models\Sedes;

$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$model->id_sede)->all();

$idInstitucion = ArrayHelper::getColumn($nombreSede, 'id_instituciones' );
$idInstitucion =$idInstitucion[0];

$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$model->id_sede];

/* @var $this yii\web\View */
/* @var $model app\models\RecursoInfraestructuraPedagogica */

$this->title = 'Modificar Recurso de Infraestructura Pedagógica: ';
$this->params['breadcrumbs'][] = [
									'label' => 'Recurso Infraestructura Pedagogicas',
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sede,
											 ],
								 ];	
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="recurso-infraestructura-pedagogica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	=> $model,
		'sedes' 	=> $sedes,
		'estados'	=> $estados,
    ]) ?>

</div>
