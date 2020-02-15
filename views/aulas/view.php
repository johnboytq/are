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
Fecha: 03-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de aulas
---------------------------------------
Modificaciones:
Fecha: 03-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se cambia botones Update y Delete por Actualizar y Eliminar respectivamente
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Sedes;
use app\models\TiposAulas;
use yii\helpers\ArrayHelper;

$modelSedes = Sedes::findOne($model->id_sedes);

/* @var $this yii\web\View */
/* @var $model app\models\Aulas */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
									'label' => 'Aulas', 
									'url' => [
												'index',
												'idInstitucion'	=> $modelSedes->id_instituciones,
												'idSedes' 		=> $modelSedes->id,
											 ]
								 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aulas-view">

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
            'id',
            'descripcion',
            'capacidad',
			[
				'attribute' => 'id_sedes',
				'value' => function( $model ){
					$sedes = Sedes::findOne($model->id_sedes);
					return $sedes ? $sedes->descripcion : '';
				},
				'filter' => ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			],
			[
				'attribute' => 'id_tipos_aulas',
				'value' => function( $model ){
					$tiposAulas = TiposAulas::findOne($model->id_tipos_aulas);
					return $tiposAulas ? $tiposAulas->descripcion : '';
				},
				'filter' => ArrayHelper::map(Sedes::find()->all(), 'id', 'descripcion' ),
			],
        ],
    ]) ?>

</div>
