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

/* @var $this yii\web\View */
/* @var $model app\models\PerfilesPersonasInstitucion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles Personas Instituciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perfiles-personas-institucion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de eleminar este ítem?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
			[
				'attribute'=>'id_perfiles_x_persona',
				'value' => function( $model )
				{
					/**
					* Llenar nombre personas por perfil
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT pp.id, concat(p.nombres,' ',p.apellidos) as nombres
														FROM public.perfiles_x_personas as pp, personas as p, perfiles as pe, perfiles_x_personas_institucion as ppi
														WHERE pp.id = $model->id_perfiles_x_persona
														AND p.id = pp.id_personas
														AND pe.id = pp.id_perfiles
														AND pp.estado = 1
														AND p.estado = 1
														AND pe.estado = 1
														AND ppi.id_perfiles_x_persona = pp.id
					");
					$result = $command->queryAll();
								
					return $result[0]['nombres'];
				},
				
			],
			[
				'attribute'=>'id_institucion',
				'value' => function( $model )
				{
					/**
					* Llenar las instituciones
					*/
					//variable con la conexion a la base de datos 
					$connection = Yii::$app->getDb();
					$command = $connection->createCommand("SELECT i.id, i.descripcion
														FROM public.instituciones as i, perfiles_x_personas_institucion as ppi
														where i.estado = 1
														AND ppi.id_institucion = i.id
														AND ppi.id_institucion = $model->id_institucion
														AND ppi.estado = 1
					");
					$result = $command->queryAll();
								
					return $result[0]['descripcion'];
				},
				
			], 
			'observaciones',
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
