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
Fecha: 14-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de AsignaturasNivelesSedes
---------------------------------------
Modificaciones:
Fecha: 14-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio nombre botones
Cambio en los datos en la forma que se muestran
Cambio mensaje de confirmacion al borra un elemento
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\DetailView;
use	yii\helpers\ArrayHelper;

use app\models\Asignaturas;
use app\models\SedesNiveles;
use app\models\Niveles;
use app\models\Sedes;

/* @var $this yii\web\View */
/* @var $model app\models\AsignaturasNivelesSedes */

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = ['label' => 'Asignaturas Niveles Sedes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignaturas-niveles-sedes-view">

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
            [
				'attribute'=>'id_sedes_niveles',
				'value' => function( $model )
				{
					//se buscan los id de los niveles y las sedes para mostrarlos en el index
					$sedesNiveles = SedesNiveles::find()->where('id='.$model->id_sedes_niveles)->orderBy('id_sedes')->all();
					
					$idNiveles = ArrayHelper::getColumn($sedesNiveles, 'id_niveles' );
					$idSedes = ArrayHelper::getColumn($sedesNiveles, 'id_sedes' );
					
					//nombre de la sede segun $idSedes
					$nombreSede = Sedes::find()->where('id='.$idSedes[0])->all();
					$nombreSede = ArrayHelper::getColumn($nombreSede, 'descripcion' );
					
					//nombre del nivel segun $idNiveles
					$nombreNivel = Niveles::find()->where('id='.$idNiveles[0])->all();
					$nombreNivel = ArrayHelper::getColumn($nombreNivel, 'descripcion' );
										
					$nombreSede = implode(',',$nombreSede);
					$nombreNivel = implode(',',$nombreNivel);
										
					// echo $nombreNivel;
					return $nombreSede.'-'.$nombreNivel;
				},
				
			],
            
			[
				'attribute'=>'id_asignaturas',
				'value' => function( $model )
				{
					$asignaturas = Asignaturas::findOne($model->id_asignaturas);
					return $asignaturas ? $asignaturas->descripcion : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(Asignaturas::find()->all(), 'id', 'descripcion' ),
				
			],

            'intensidad',
        ],
    ]) ?>

</div>
