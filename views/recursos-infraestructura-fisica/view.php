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
Fecha: 10-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Recursos Infraestructura Fisica
---------------------------------------
Modificaciones:
Fecha: 10-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Se quita de la vista el estado y el id_sedes
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\RecursosInfraestructuraFisica */
$idSedes = $model->id_sede;
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$idInstitucion = ArrayHelper::map($nombreSede,'id','id_instituciones');
$idInstitucion = $idInstitucion[$idSedes];

$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];


$this->title = "Detalle";
$this->params['breadcrumbs'][] = [
								'label' => 'Recursos Infraestructuras Físicas', 
								'url' => [
											'index',
											'idInstitucion' => $idInstitucion, 
											'idSedes' 		=> $model->id_sede,
										 ]
							 ];
$this->params['breadcrumbs'][] = $this->title;





?>
<div class="recursos-infraestructura-fisica-view">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'cantidad_aulas_regulares',
            'cantidad_aulas_multiples',
            'cantidad_oficinas_admin',
            'cantidad_aulas_profesores',
            'cantidad_espacios_deportivos',
            'cantidad_baterias_sanitarias',
            'cantidad_laboratorios',
            'cantidad_portatiles',
            'cantidad_computadores',
            'cantidad_tabletas',
            'cantidad_bibliotecas_salas_lectura',
            'programas_informaticos_admin',
			'observaciones',
        ],
    ]) ?>

</div>
