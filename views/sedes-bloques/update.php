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
Fecha: 12-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Sedes por Bloques
---------------------------------------
Modificaciones:
Fecha: 12-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio en el nombre del boton
Cambios realizados: - Cambio en la miga de pan
Cambios realizados: - Se cambia el titulo para que muestre el nombre la sede
---------------------------------------
**********/

use yii\helpers\Html;
use app\models\Sedes;
use yii\helpers\ArrayHelper;
//se consulta el nombre de la sede para mostrar en el titulo
$sedes = new Sedes();
$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
$sedes = ArrayHelper::map($sedes,'descripcion','id_instituciones');
$nombreSede = key($sedes);

//se obtien el id de consultar la sede para usarla en la miga de pan
$idInstitucion = $sedes[key($sedes)];
$this->title = $nombreSede;


/* @var $this yii\web\View */
/* @var $model app\models\SedesBloques */


// $this->params['breadcrumbs'][] = ['label' => 'Sedes Bloques', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
									'label' => 'Sedes por Bloques', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="sedes-bloques-update">

    <h1><?= Html::encode('Actualizar') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'bloques'=>$bloques,
		'idSedes'=>$idSedes,
    ]) ?>

</div>
