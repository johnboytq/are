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
Fecha: 25-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de participacion proyectos jornada
---------------------------------------
Modificaciones:
Fecha: 25-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - miga de pan
nombre a los id
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\NombresProyectosParticipacion;
use app\models\Personas;
use app\models\Perfiles;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipacionProyectosJornada */

$this->title = $nombreInstitucion;
	
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Participacion Proyectos Jornada', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
				 ]
	];
$this->params['breadcrumbs'][] = "Detalle";
?>
<div class="participacion-proyectos-jornada-view">

    <h1><?= Html::encode("Detalle") ?></h1>

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
            [
				'attribute'=>'nombre_programa',
				'value' => function( $model )
				{
					$nombrePrograma= NombresProyectosParticipacion::findOne($model->nombre_programa);
					return $nombrePrograma ? $nombrePrograma->descripcion : '';
				}, //para buscar por el nombre
				
			],	
			[
				'attribute'=>'nombre_participante',
				'value' => function( $model )
				{
					$nombrePersona= Personas::findOne($model->nombre_participante);
					return $nombrePersona ? $nombrePersona->nombres." ".$nombrePersona->apellidos : '';
				}, //para buscar por el nombre
				
			],
			[
				'attribute'=>'tipo',
				'value' => function( $model )
				{
					$perfil= Perfiles::findOne($model->tipo);
					return $perfil ? $perfil->descripcion: '';
				}, //para buscar por el nombre
				
			],
            'objetivo',
            'duracion',
            'ano_inicio',
            'ano_fin',
            'tematica',
            'areas',
            'otros',
            'materiales_recursos',
            'logros',
            'observaciones',
        ],
    ]) ?>

</div>
