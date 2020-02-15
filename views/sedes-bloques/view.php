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
use app\models\Bloques;

/* @var $this yii\web\View */
/* @var $model app\models\SedesBloques */




$sedes = new Sedes();
$sedes = $sedes->find()->where('id='.$model->id_sedes)->all();
$sedes = ArrayHelper::map($sedes,'descripcion','id_instituciones');
$nombreSede = key($sedes);
$idInstitucion = $sedes[$nombreSede];

$this->title = $nombreSede;
$this->params['breadcrumbs'][] = [
									'label' => 'Sedes por Bloques', 
									'url' => [
												'index',
												'idInstitucion' => $idInstitucion, 
												'idSedes' 		=> $model->id_sedes,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-bloques-view">

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
				'attribute'=>'id_bloques',
				/*
				se consulta la descripcion del bloques 
				*/
				'value' => function( $model ){
					$bloques = Bloques::findOne($model->id_bloques);
					return  $bloques ? $bloques->descripcion : '';
						
				},
				
			],
        ],
    ]) ?>

</div>
