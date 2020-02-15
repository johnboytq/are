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
use app\models\AreasEnsenanza;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SedesAreasEnsenanza */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
									'label' => 'Especialidad', 
									'url' => [
												'index',
												'idInstitucion' => $modelInstitucion->id,
												'idSedes' 		=> $modelSedes->id,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sedes-areas-ensenanza-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
			[
				'attribute' => 'id_sedes',
				'value' 	=> function( $model ){
									$sedes = Sedes::findOne($model->id_sedes);
									return $sedes ? $sedes->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			],
   			[
				'attribute' => 'id_areas_ensenanza',
				'value' 	=> function( $model ){
									$sedes = AreasEnsenanza::findOne($model->id_areas_ensenanza);
									return $sedes ? $sedes->descripcion : '';
							   },
				'filter' 	=> ArrayHelper::map(AreasEnsenanza::find()->all(), 'id', 'descripcion' ),
			],
        ],
    ]) ?>

</div>
