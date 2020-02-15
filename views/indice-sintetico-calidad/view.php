<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Estados;
use app\models\IndiceEspecifico;

/* @var $this yii\web\View */
/* @var $model app\models\IndiceSinteticoCalidad */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Indice Sintético de Calidad', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indice-sintetico-calidad-view">

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
            'anio',
			[
				'attribute' => 'id_indice_especifico',
				'value'		=>  function( $model ){
					$indice = IndiceEspecifico::findOne( $model->id_indice_especifico );
					return $indice ? $indice->descripcion : '';
				}
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
