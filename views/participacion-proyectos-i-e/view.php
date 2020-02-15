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

use app\models\Estados;
use app\models\Instituciones;
use app\models\NombresProyectosParticipacion;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipacionProyectosIE */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Participacion Proyectos Ies', 'url' => ['index', 'idInstitucion' => $model->id_institucion ]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participacion-proyectos-ie-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [ 
				'attribute' => 'programa_proyecto', 
				'value' => function( $model ){
					$nombreProyecto = NombresProyectosParticipacion::findOne( $model->programa_proyecto );
					return $nombreProyecto ? $nombreProyecto->descripcion: '' ;
				}, 
			],
            'participacion:boolean',
            'operador',
            'entidad_financia',
            'objetivo',
            'duracion',
            'anio_inicio',
            'anio_finalizacion',
            'tematica',
            'areas',
            'sedes',
            'numero_docentes',
            'numero_estudiantes',
            'numero_padres',
            'numero_directivos',
            'otros',
            'materiales_recursos',
            'logros',
            'observaciones',
            [ 
				'attribute' => 'id_institucion',
				'value' => function( $model ){
					$institucion = Instituciones::findOne( $model->id_institucion );
					return $institucion ? $institucion->descripcion: '' ;
				},
			],
            [ 
				'attribute' => 'estado',
				'value' => function( $model ){
					$estado = Estados::findOne( $model->estado );
					return $estado ? $estado->descripcion: '' ;
				},
			],
        ],
    ]) ?>

</div>
