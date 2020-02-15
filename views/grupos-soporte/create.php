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
Fecha: Fecha en formato (13-04-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario grupos soporte crear
---------------------------------------
*******/

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GruposSoporte */

$this->title = 'Agregar Grupos Soporte';

$this->params['breadcrumbs'][] = [
									'label' => 'Grupos Soportes', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-soporte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipoGruposSoporte' => $tipoGruposSoporte,
        'sedes' => $sedes,
        'sedesJornadas' => $sedesJornadas,
        'docentes' => $docentes,
        'estados' => $estados,
    ]) ?>

</div>
