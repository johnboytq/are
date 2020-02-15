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
use app\models\Instituciones;
$nombreInstitucion = Instituciones::find()->where(['id' => $idInstitucion])->one();
$idInstitucion = $nombreInstitucion->id;
$nombreInstitucion = $nombreInstitucion->descripcion;
/* @var $this yii\web\View */
/* @var $model app\models\InfraestructuraEducativa */

$this->title = "$nombreInstitucion";
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Infraestructura Educativa', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
				 ]
	];	
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="infraestructura-educativa-create">

    <h1><?= Html::encode("Agregar Infraestructura Educativas") ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'sedes'=> $sedes,
		'estados'=>$estados,
    ]) ?>

</div>
