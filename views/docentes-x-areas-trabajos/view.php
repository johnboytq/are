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

use app\models\Personas;
use app\models\AreasTrabajos;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DocentesXAreasTrabajos */

$this->title = $model->id_perfiles_x_personas_docentes;
$this->params['breadcrumbs'][] = ['label' => 'Docentes Xareas Trabajos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docentes-xareas-trabajos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id_perfiles_x_personas_docentes' => $model->id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $model->id_areas_trabajos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id_perfiles_x_personas_docentes' => $model->id_perfiles_x_personas_docentes, 'id_areas_trabajos' => $model->id_areas_trabajos], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute' => 'id_perfiles_x_personas_docentes',
				'label'		=> 'Docente',
				'value' 	=> function( $model ){
									$personas = Personas::find()
													->select( "d.id_perfiles_x_personas as id, ( personas.nombres || ' ' || personas.apellidos ) nombres" )
													->innerJoin('perfiles_x_personas pf', 'personas.id=pf.id_personas' )
													->innerJoin('docentes d', 'd.id_perfiles_x_personas=pf.id' )
													->where( 'personas.estado=1' )
													->where( 'd.estado=1' )
													->where( 'd.id_perfiles_x_personas='.$model->id_perfiles_x_personas_docentes )
													->one();
									return $personas ? $personas->nombres: '';
								},
			],
			[
				'attribute' => 'id_areas_trabajos',
				'value' 	=> function( $model ){
									$areasTrabajo = AreasTrabajos::find($model->id_areas_trabajos)->one();
									return $areasTrabajo ? $areasTrabajo->descripcion: '';
								},
			],
        ],
    ]) ?>

</div>
