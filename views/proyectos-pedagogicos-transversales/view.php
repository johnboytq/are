<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Personas;
use app\models\Sedes;
use app\models\Estados;
use app\models\AreasTrabajos;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectosPedagogicosTransversales */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proyectos Pedagogicos Transversales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyectos-pedagogicos-transversales-view">

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
            'codigo_grupo',
            'nombre_grupo',
            [
				'attribute' => 'coordinador',
				'value' 	=> function( $model ){
					$personas = Personas::findOne( $model->coordinador );
					return $personas ? $personas->nombres.' '.$personas->apellidos : '';
				},
			],
			[
				'attribute' => 'area',
				'value' => function( $model ){
					$area = AreasTrabajos::findOne( $model->area );
					return $area ? $area->descripcion : '';
				},
			],
            'correo',
            'celular',
            'linea_investigacion_1',
            'linea_investigacion_2',
            'linea_investigacion_3',
            [
				'attribute' => 'estado',
				'value' 	=> function( $model ){
					$estados = Estados::findOne( $model->estado );
					return $estados ? $estados->descripcion : '';
				},
			],
        ],
    ]) ?>

</div>
