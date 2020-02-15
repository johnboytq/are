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
Cambios realizados: Se envía la vista _form el id de la institución seleccionada desde la lista de sedes 
					y a la url del breadcrumbs también
---------------------------------------
**********/

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sedes */

$this->title = 'Agregar Sede';
$this->params['breadcrumbs'][] = ['label' => 'Sedes', 'url' => ['index', 'idInstitucion' =>$idInstitucion ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-create">

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
        'comunas'		 => [],
        'idInstitucion'	 => $idInstitucion,
    ]) ?>

</div>
