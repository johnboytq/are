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

use app\models\Sedes;
use app\models\Estados;
use app\models\Instituciones;
/* @var $this yii\web\View */
/* @var $model app\models\InfraestructuraEducativa */


$idInstitucion = Sedes::findOne($model->id_sede);
$idInstitucion = $idInstitucion ? $idInstitucion->id_instituciones : ''; 

$nombreInstitucion = Instituciones::find()->where(['id' => $idInstitucion])->one();
$nombreInstitucion = $nombreInstitucion->descripcion;
$this->title = "$nombreInstitucion";
$this->params['breadcrumbs'][] = 
	[
		'label' => 'Infraestructura Educativa', 
		'url' => [
					'index',
					'idInstitucion' => $idInstitucion, 
				 ]
	];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="infraestructura-educativa-view">

    <h1><?= Html::encode("Detalles") ?></h1>

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
				'attribute'=>'id_sede',
				'value' => function( $model )
				{
					$sede = Sedes::findOne($model->id_sede);
					return $sede ? $sede->descripcion : '';
				},
			],
            'objeto_intervencion:boolean',
            'intervencion_infraestructura',
            'alcance_intervencion',
            'presupuesto',
            'cumplimiento_pedido',
			[
				'attribute'=>'estado',
				'value' => function( $model )
				{
					$estado = Estados::findOne($model->estado);
					return $estado ? $estado->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
