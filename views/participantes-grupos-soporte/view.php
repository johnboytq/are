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
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipantesGruposSoporte */

$this->title = "Detalles";
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
<div class="participantes-grupos-soporte-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id,'idJornadas'=>$idJornadas,'TiposGruposSoporte'=>$TiposGruposSoporte,'idGruposSoporte'=>$idGruposSoporte], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id,'idJornadas'=>$idJornadas,'TiposGruposSoporte'=>$TiposGruposSoporte,'idGruposSoporte'=>$idGruposSoporte], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model2,
        'attributes' => [
            'Participantes',
            'edad',
			'Grado',
			'Sede',
			'Nombre Equipo',
           
        ],
    ]) ?>

</div>
