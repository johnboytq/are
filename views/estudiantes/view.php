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
/* @var $model app\models\Estudiantes */


use	yii\helpers\ArrayHelper;
use app\models\Sedes;
$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();

$idInstitucion = ArrayHelper::getColumn($nombreSede, 'id_instituciones' );
$idInstitucion =$idInstitucion[0];

$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];



$this->title = 'Detalle';
$this->params['breadcrumbs'][] = [
									'label' => 'Matricular Estudiante', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];	
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estudiantes-view">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_perfiles_x_personas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id_perfiles_x_personas], [
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
            [
				'attribute'=>'id_perfiles_x_personas',
				'value' => function( $model )
				{
					/**
					* Llenar nombre del docente
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("
					SELECT es.id_perfiles_x_personas, concat(pe.nombres,' ',pe.apellidos) as nombres
					FROM public.estudiantes as es, public.perfiles_x_personas as pp, public.personas as pe
					where es.id_perfiles_x_personas = pp.id
					and pp.id_personas = pe.id
					and es.id_perfiles_x_personas =$model->id_perfiles_x_personas
					");
					$result = $command->queryAll();
					
					return $result[0]['nombres'];
				},
				
			],
            [
				'attribute'=>'id_paralelos',
				'value' => function( $model )
				{
					$paralelos = $model->paralelos;
					return $paralelos ? $paralelos->descripcion : '';
				}, //para buscar por el nombre
				
			],
            
        ],
    ]) ?>

</div>
