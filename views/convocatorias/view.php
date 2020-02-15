<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Estados;
use app\models\Sedes;

/* @var $this yii\web\View */
/* @var $model app\models\Convocatorias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Convocatorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="convocatorias-view">

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
			[
				'attribute' => 'id_sede',
				'value' 	=> function( $model ){
					$sede = Sedes::findOne( $model->id_sede );
					return $sede ? $sede->descripcion : '';
				},
			],
            'nro_convocatoria',
            'grupo',
            'fecha_inicio',
            'fecha_final',
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
