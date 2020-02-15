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
Descripción: CRUD de sedes
---------------------------------------
Modificaciones:
Fecha: 02-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se envía a la vista _form los municipios y el id de la institución seleccionada desde la lista de sedes 
					y a la url del breadcrumbs también
---------------------------------------
**********/

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sedes */

$this->title = 'Actualizar Sede:';
$this->params['breadcrumbs'][] = ['label' => 'Sedes', 'url' => ['index', 'idInstitucion' => $idInstitucion] ];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sedes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 		 => $model,
        'barriosVeredas' => $barriosVeredas,
        'calendarios' 	 => $calendarios,
        'estratos'	 	 => $estratos,
        'generosSedes'	 => $generosSedes,
        'instituciones'	 => $instituciones,
        'modalidades'	 => $modalidades,
        'tenencias'	 	 => $tenencias,
        'zonificaciones' => $zonificaciones,
        'estados' 		 => $estados,
        'municipios'	 => $municipios,
        'comunas'	 	 => $comunas,
        'idInstitucion'	 => $idInstitucion,
    ]) ?>

</div>
