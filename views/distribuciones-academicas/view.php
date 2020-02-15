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
Fecha: (16-03-2018)
Desarrollador: Viviana Rodas
Descripción: Ver detalle distribuiones academicas - indicador de desempeño
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\DistribucionesAcademicas */

$this->title = $model->id;

$this->params['breadcrumbs'][] = [
									'label' => 'Distribuciones Académicas', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
								 
$this->params['breadcrumbs'][] = $this->title;
// $this->params['breadcrumbs'][] = ['label' => 'Distribuciones Academicas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribuciones-academicas-view">

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
				'attribute'=>'id_asignaturas_x_niveles_sedes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre asignatura por id asignaturas niveles sedes
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT a.descripcion
															FROM asignaturas as a, asignaturas_x_niveles_sedes as ans
															WHERE ans.id_asignaturas = a.id
															AND ans.id = $model->id_asignaturas_x_niveles_sedes;");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
			[
				'attribute'=>'id_perfiles_x_personas_docentes',
				'value' => function( $model )
				{
					/**
					* Llenar nombre del docente
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("select concat(p.nombres,' ',p.apellidos) as nombres
															from personas as p, perfiles_x_personas as pp, docentes as d, distribuciones_academicas as da
															where p.id= pp.id_personas
															and p.estado=1
															and da.id_perfiles_x_personas_docentes = d.id_perfiles_x_personas
															and d.id_perfiles_x_personas = pp.id
															and pp.id_personas = p.id
															and d.id_perfiles_x_personas = $model->id_perfiles_x_personas_docentes;
															");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			], 
            [
				'attribute'=>'id_aulas_x_sedes',
				'value' => function( $model )
				{
					/**
					* Llenar la descripcion del aula
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand(" select a.descripcion
															from aulas as a, distribuciones_academicas as da
															where a.id= da.id_aulas_x_sedes
															and a.estado=1
															and a.id = $model->id_aulas_x_sedes
															");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
            'fecha_ingreso',
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
