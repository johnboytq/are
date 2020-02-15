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
use yii\helpers\ArrayHelper;
use app\models\Sedes;
use app\models\SedesJornadas;
use app\models\Jornadas;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\Paralelos */
/**********
Versión: 001
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Paralelos
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - cambio en la miga de pan para que regrese a la lista de la sede que le corresponde
este cambio se hace debido a que se debe pasar por selccionar institucion y sede
Cambios realizados: modificacion de los datos en DetailView para mostrar los datos que corresponde con los Ids

-------------
**********/
$this->title = $model->descripcion;
$this->params['breadcrumbs'][] = [
									'label' => 'Grupos por nivel', 
									'url' => [
												'index',
												'idInstitucion' => $idInstituciones, 
												'idSedes' 		=> $idSedes,
											 ]
								 ];
								 
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="paralelos-view">

    <h1><?= Html::encode('Ver') ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
            'descripcion',            
			[
				'attribute'=>'id_sedes_jornadas',
				'value'=> $jornadas,
			],
			[
				'attribute'=>'id_sedes_niveles',
				'value'=> $niveles,
			],
            'ano_lectivo',
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
