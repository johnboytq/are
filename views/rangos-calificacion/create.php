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



use yii\helpers\ArrayHelper;

$nombreinstitucion = new Instituciones();
$nombreinstitucion = $nombreinstitucion->find()->where('id='.$idInstitucion)->all();
$nombreinstitucion = ArrayHelper::map($nombreinstitucion,'id','descripcion');
$nombreinstitucion = $nombreinstitucion[$idInstitucion];


/* @var $this yii\web\View */
/* @var $model app\models\RangosCalificacion */


$this->title = 'Agregar Rangos Calificacion';
$this->params['breadcrumbs'][] = [
									'label' => 'Rangos Calificaciones', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rangos-calificacion-create">

    <h1><?= Html::encode('Agregar') ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'idInstitucion'=>$idInstitucion,
		'institucionNombre'=>$institucionNombre,
		'estados'=>$estados,
		'TiposCalificacion'=>$TiposCalificacion,
		
    ]) ?>

</div>
