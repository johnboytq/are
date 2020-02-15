<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Instituciones;
use app\models\AsignaturaEspecifica;
use app\models\AsignaturasEvaluadas;
use app\models\Estados;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasSaberCali */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => $breadcrumbsTitle, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultados-pruebas-saber-cali-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que quiere borrar este registro?',
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
				'value'	 	=> function( $model ){
					$institucion = Instituciones::findOne( $model->id_institucion );
					return $institucion ? $institucion->descripcion : '' ;
				}
			],
            'anio',
            [
				'attribute' => 'id_asignatura_especifica',
				'value'		=> function( $model ){
					$asignatura = AsignaturaEspecifica::findOne( $model->id_asignatura_especifica );
					return $asignatura ? $asignatura->descripcion : '' ;
				}
			],
			'valor',
			[
				'attribute' => 'estado',
				'value'		=> function( $model ){
					$estados = Estados::findOne( $model->estado );
					return $estados ? $estados->descripcion : '' ;
				}
			],
        ],
    ]) ?>

</div>
