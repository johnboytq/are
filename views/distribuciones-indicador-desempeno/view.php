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
Fecha: (23-03-2018)
Desarrollador: Viviana Rodas
Descripción: Ver detalle de distribuiones academicas - indicador de desempeño
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\DistribucionesIndicadorDesempeno */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Distribuciones Indicador Desempenos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribuciones-indicador-desempeno-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea eliminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute'=>'id_distribuciones',
				'value' => function( $model )
				{
					/**
					* Llenar nombre asignatura por id asignaturas niveles sedes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("select concat(a.descripcion,' ',p.descripcion) as distribucion  
															from distribuciones_x_indicador_desempeno as did, distribuciones_academicas as da, asignaturas as a, asignaturas_x_niveles_sedes as ans,paralelos as p
															where did.id_distribuciones = da.id
															and da.id_asignaturas_x_niveles_sedes = ans.id
															and ans.id_asignaturas = a.id
															and da.id_paralelo_sede = p.id
															and da.id = $model->id_distribuciones
															group by a.descripcion, p.descripcion
															");
					$result = $command->queryAll();
								
					return $result[0]['distribucion'];
				},
				
			], 
            
			[
				'attribute'=>'id_indicador_desempeno',
				'value' => function( $model )
				{
					/**
					* Llenar nombre asignatura por id asignaturas niveles sedes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT id.descripcion
															FROM indicador_desempeno as id, distribuciones_x_indicador_desempeno as did
															WHERE id.estado = 1
															AND id.id = did.id_indicador_desempeno
															AND id.id = $model->id_indicador_desempeno
															AND did.estado = 1
															");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			],
			[
				'attribute' => 'estado',
				'value' => function( $model )
				{
					$estados = Estados::findOne( $model->estado );
					return $estados ? $estados->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
