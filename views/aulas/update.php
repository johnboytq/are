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
Fecha: 02-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: Vista para actualizar aulas
---------------------------------------
Modificaciones:
Fecha: 02-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se corrige la varibales tiposAulas, estaba con sedes
---------------------------------------
**********/


use yii\helpers\Html;

use app\models\Sedes;

$modelSedes = Sedes::findOne( $model->id_sedes );

/* @var $this yii\web\View */
/* @var $model app\models\Aulas */

$this->title = 'Modificar aula';
$this->params['breadcrumbs'][] = [
									'label' => 'Aulas', 
									'url' 	=> [
													'index',
													'idInstitucion' => $modelSedes->id_instituciones,
													'idSedes' 		=> $modelSedes->id,
												]
								];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aulas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	 => $model,
        'sedes' 	 => $sedes,
        'tiposAulas' => $tiposAulas,
    ]) ?>

</div>
