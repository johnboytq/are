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
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Nombre de los botones

---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\DetailView;
use	yii\helpers\ArrayHelper;

use app\models\Personas;
/* @var $this yii\web\View */
/* @var $model app\models\RepresentantesLegales */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Estudiantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="representantes-legales-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            
			// SELECT concat(p.nombres,' ', p.apellidos ) as nombres
			// FROM public.personas as p
			// join public.perfiles_x_personas as pp on pp.id_personas= p.id
			// where pp.id=8
			
			[
				'attribute' => 'id_perfiles_x_personas',
				'value'		=> function( $model )
								{
									//consulta el nombre de la persona pertiendo desde la tabla representantes_legales
									$connection = Yii::$app->getDb();
									$command = $connection->createCommand("
									select concat(p.nombres,' ',p.apellidos) as nombres
									from personas as p, representantes_legales as rl, perfiles_x_personas pp
									where rl.id = $model->id
									and rl.id_perfiles_x_personas = pp.id
									and pp.id_personas = p.id
									");
									$result = $command->queryAll();
									$nombrePersona = $result[0]['nombres'];
									
									return $nombrePersona;
								},
			],
           [
				'attribute' => 'id_personas',
				'value'		=> function( $model){
									$personas = Personas::findOne( $model->id_personas );
									return $personas ? $personas->nombres." ".$personas->apellidos : '';
								},
			],
        ],
    ]) ?>

</div>
