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

use app\models\Periodos;
use	yii\helpers\ArrayHelper;
use app\models\PonderacionResultados;
/* @var $this yii\web\View */
/* @var $model app\models\PonderacionResultados */

use app\models\Sedes;

$idSedes = $model->id_sede;

$nombreSede = Sedes::find()->where('id='.$idSedes)->one();
$idInstitucion = $nombreSede->id_instituciones;
$nombreSede = $nombreSede->descripcion;
 

/* @var $this yii\web\View */
/* @var $model app\models\PonderacionResultados */

$this->title = 'Detalle';
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Ponderación de resultados', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
					'idSedes' 		=> $idSedes,
				 ]
	];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ponderacion-resultados-view">

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
            [
				'attribute'=>'id_periodo',
				'value' => function( $model )
				{
					$Periodos = Periodos::findOne($model->id_periodo);
					return $Periodos ? $Periodos->descripcion : '';
				}, //para buscar por el nombre
				'filter' 	=> ArrayHelper::map(Periodos::find()->all(), 'id', 'descripcion' ),
				
			],
			[
				'attribute'=>'calificacion',
				//para buscar por el nombre
				'filter' 	=> ArrayHelper::map(PonderacionResultados::find()->all(), 'calificacion', 'calificacion' ),
				
			],	
        ],
    ]) ?>

</div>
