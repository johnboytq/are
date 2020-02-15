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
use app\models\Estados;
use app\models\TiposContratos;

/* @var $this yii\web\View */
/* @var $model app\models\VinculacionDocentes */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vinculacion Docentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vinculacion-docentes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
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
            'id',
            'resolucion_numero',
            'resolucion_desde',
            'antiguedad',
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
				'attribute' => 'id_tipos_contratos',
				'value' 	=> function( $model ){
									$tiposContrato = TiposContratos::findOne( $model->id_tipos_contratos);
									return $tiposContrato ? $tiposContrato->descripcion: '';
								},
			],
			[
				'attribute' => 'estado',
				'value' 	=> function( $model ){
									$estado = Estados::findOne( $model->estado);
									return $estado ? $estado->descripcion: '';
								},
			],
        ],
    ]) ?>

</div>
