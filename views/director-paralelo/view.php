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
Fecha: 13-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Director paralelo (grupo)
---------------------------------------
Modificaciones:
Fecha: 13-04-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - La institución y la sede se toman de acuerdo a la sessión
---------------------------------------
Fecha: 13-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se reemplazan los id por sus nombre correspondientes
se cambias las etiquetas de los botones
miga de pan
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\personas;
use app\models\PerfilesXPersonas;
use app\models\Paralelos;
use app\models\Sedes;
use	yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\DirectorParalelo */



// $connection = Yii::$app->getDb();
// //la sede y la institucion para la miga de pan
// $command = $connection->createCommand("
// SELECT sj.id_sedes as idsedes, s.id_instituciones as institucion
// FROM director_paralelo  as dp, paralelos as p, sedes_jornadas as sj, sedes as s
// where dp.id_paralelo = p.id
// and p.id_sedes_jornadas = sj.id
// and sj.id_sedes = s.id
// and dp.id = $model->id
// group by sj.id_sedes, s.id_instituciones
// ");
// $result = $command->queryAll();

// $idSedes = $result[0]['idsedes'];
// $idInstitucion = $result[0]['institucion'];

$idInstitucion 	= $_SESSION['instituciones'][0];
$idSedes 		= $_SESSION['sede'][0];


$nombreSede = new Sedes();
$nombreSede = $nombreSede->find()->where('id='.$idSedes)->all();
$nombreSede = ArrayHelper::map($nombreSede,'id','descripcion');
$nombreSede = $nombreSede[$idSedes];
$this->title = 'Detalles';
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Director de grupo', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
					'idSedes' 		=> $idSedes,
				 ]
	];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="director-paralelo-view">

    <h1><?= Html::encode($nombreSede) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('borrar', ['delete', 'id' => $model->id], [
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
				'attribute'=>'id_perfiles_x_personas_docentes',
				'value' => function( $model )
				{
					$id = PerfilesXPersonas::findOne($model->id_perfiles_x_personas_docentes);
					$personas = Personas::findOne($id);
					return $personas ? $personas->nombres." ".$personas->apellidos : '';
				}, 
			],	
			[
				'attribute'=>'id_paralelo',
				'value' => function( $model )
				{
					$paralelo = Paralelos::findOne($model->id_paralelo);
					return $paralelo ? $paralelo->descripcion : '';
				}, 
			],	
			
        ],
    ]) ?>

</div>
