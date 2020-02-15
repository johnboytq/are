<?php

/**********
Versión: 001
Fecha: 12-07-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD PMI
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\SubProcesoEvaluacion;
use app\models\ProcesoEspecifico;
use app\models\AreaGestion;
use app\models\Estados;
use app\models\Instituciones;
use app\models\Zonificaciones;
use app\models\ComunasCorregimientos;

/* @var $this yii\web\View */
/* @var $model app\models\Pmi */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'PMI', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pmi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
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
			[
				'attribute' => 'id_institucion',
				'value' 	=> function( $model ){
					$institucion = Instituciones::findOne( $model->id_institucion );
					return $institucion ? $institucion->descripcion : '';
				},
			],
            'codigo_dane',
            'anio',
            [
				'attribute' => 'comuna',
				'value' 	=> function( $model ){
					$comuna = ComunasCorregimientos::findOne( $model->comuna );
					return $comuna ? $comuna->descripcion : '';
				},
			],
			[
				'attribute' => 'zona',
				'value' 	=> function( $model ){
					$zona = Zonificaciones::findOne( $model->zona );
					return $zona ? $zona->descripcion : '';
				},
			],
			[
				'attribute' => 'id_proceso_especifico',
				'value' 	=> function( $model ){
					$proceso = ProcesoEspecifico::findOne( $model->id_proceso_especifico );
					return $proceso ? $proceso->descripcion : '';
				},
			],
            'valor',
			[
				'attribute' => 'estado',
				'value' 	=> function( $model ){
					$estado = Estados::findOne( $model->estado );
					return $estado ? $estado->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
