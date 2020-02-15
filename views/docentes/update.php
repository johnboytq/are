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
Fecha: Fecha modificacion (24-04-2018)
Desarrollador: Viviana Rodas
Descripción: Se modifica para llenar los docentes
---------------------------------------

*/

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Docentes */

$this->title = 'Modificar docente: ';
$this->params['breadcrumbs'][] = ['label' => 'Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_perfiles_x_personas, 'url' => ['view', 'id' => $model->id_perfiles_x_personas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="docentes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	  			=> $model,
		'personas' 	  			=> $personas,
		'escalafones' 			=> $escalafones,
		'estados' 	  			=> $estados,
    ]) ?>

</div>
