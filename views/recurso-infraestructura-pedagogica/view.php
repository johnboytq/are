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
Fecha: 09-04-2018
Persona encargada: Edwin Molina Grisales
CRUD de RECURSOS DE INFRAESTRUCTURA PEDAGOGICA
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RecursoInfraestructuraPedagogica */

use	yii\helpers\ArrayHelper;
use app\models\Sedes;
use app\models\Estados;
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$model->id_sede)->all();

$idInstitucion = ArrayHelper::getColumn($nombreSede, 'id_instituciones' );
$idInstitucion =$idInstitucion[0];

$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$model->id_sede];

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
									'label' => 'Recurso Infraestructura Pedagógicas',
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sede,
											 ],
								 ];	
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recurso-infraestructura-pedagogica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro que desea eliminar este recurso?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute' => 'id_sede',
				'value'		=> function( $model ){
					$sede = Sedes::findOne( $model->id_sede );
					return $sede ? $sede->descripcion: '';
				},
			],
            'cantidad_computdores_portatiles',
            'cantidad_aulas_tita',
            'cantidad_bibliotecas',
            'cantidad_ludotecas',
            'cantidad_salones_juegos',
			[
				'attribute' => 'estado',
				'value' => function( $model ){
					$estado = Estados::findOne( $model->estado );
					return $estado ? $estado->descripcion : '';
				},
			],
			'observaciones',
        ],
    ]) ?>

</div>
