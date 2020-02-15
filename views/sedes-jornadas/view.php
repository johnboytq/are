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
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se envía a la vista form el id de la sede y de la institución
					- Al breadcrumbs le agrego también el id de la sede y la institución
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SedesJornadas */

use app\models\Sedes;
use app\models\Jornadas;
use app\models\Instituciones;
use yii\helpers\ArrayHelper;

//Busco el modelo sedes para poder encontrar el id de la institución
$modelSedes = Sedes::findOne($model->id_sedes);

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
									'label' => 'Sedes Jornadas', 
									'url' => [
												'index',
												'idInstitucion' => $modelSedes->id_instituciones, 
												'idSedes' 		=> $modelSedes->id,
											 ]
								 ];
								 
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-jornadas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que quiere eliminar la jornada?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute' => 'id_jornadas',
				'value' => function( $model ){
					$jornadas = Jornadas::findOne($model->id_jornadas);
					return $jornadas ? $jornadas->descripcion : '';
				},
				'filter' => ArrayHelper::map(Jornadas::find()->all(), 'id', 'descripcion' ),
			],
			[
				'attribute' => 'id_sedes',
				'value' => function( $model ){
					$sedes = Sedes::findOne($model->id_sedes);
					return $sedes ? $sedes->descripcion : '';
				},
				'filter' => ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			],
        ],
    ]) ?>

</div>
