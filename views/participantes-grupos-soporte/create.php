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
/* @var $model app\models\ParticipantesGruposSoporte */

$this->title = 'Agregar participantes grupos soporte';
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Participantes Grupos Soporte', 
		'url' => [
					'index',
					'TiposGruposSoporte'=>$TiposGruposSoporte,
					'idGruposSoporte'=>$idGruposSoporte,
					'idJornadas'=>$idJornadas,
				 ]
	];	
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participantes-grupos-soporte-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'idGruposSoporte'=>$idGruposSoporte,
		'estados'=>$estados,
		'estudiantes'=>$estudiantes,
		'TiposGruposSoporte'=>$TiposGruposSoporte,
		'idGruposSoporte'=>$idGruposSoporte,
		'idJornadas'=>$idJornadas,
		'grupoSoporte'=>$grupoSoporte,
    ]) ?>

</div>
