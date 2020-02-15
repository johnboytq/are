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
/* @var $model app\models\ParticipacionProyectosIE */

$this->title = 'Agregar Participacion de Proyectos IE';
$this->params['breadcrumbs'][] = ['label' => 'Participacion Proyectos IE', 'url' => ['index', 'idInstitucion' => $idInstitucion ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participacion-proyectos-ie-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' 			=> $model,
		'idInstitucion' 	=> $idInstitucion,
		'estados' 			=> $estados,
        'nombresProyectos'	=> $nombresProyectos,
		'institucion' 		=> $institucion,
    ]) ?>

</div>
