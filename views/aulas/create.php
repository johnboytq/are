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


/* @var $this yii\web\View */
/* @var $model app\models\Aulas */

use app\models\Sedes;

$modelSedes = Sedes::findOne( $idSedes );

$this->title = 'Agregar Aula';
$this->params['breadcrumbs'][] = [
									'label' => 'Aulas', 
									'url' 	=> [
												'index',
												'idInstitucion'	=> $modelSedes->id_instituciones,
												'idSedes' 		=> $modelSedes->id,
												]
								];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aulas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 	 => $model,
		'sedes' 	 => $sedes,
		'tiposAulas' => $tiposAulas,
    ]) ?>

</div>
