<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\Sedes;
use app\models\Paralelos;
use app\models\Jornadas;
use app\models\Personas;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectoAula */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proyecto Aulas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proyecto-aula-view">

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
            [ 
				'attribute' => 'id_sede' ,
				'value' 	=> function( $model ){
					$sede = Sedes::findOne( $model->id_sede );
					return $sede ? $sede->descripcion : '';
				},
			],
            [
				'attribute' =>'id_grupo',
				'value' 	=> function( $model ){
					$grupo = Paralelos::findOne( $model->id_grupo );
					return $grupo ? $grupo->descripcion : '';
				},
			],
			'nombre_proyecto',
            [
				'attribute' => 'id_jornada',
				'value' => function( $model ){
					$jornada = Jornadas::findOne( $model->id_jornada );
					return $jornada ? $jornada->descripcion : '';
				},
			],
            [
				'attribute' => 'id_persona_coordinador',
				'value' => function( $model ){
					$coordinador = Personas::findOne( $model->id_persona_coordinador );
					return $coordinador ? $coordinador->nombres.' '.$coordinador->apellidos : '';
				},
			],
            'correo',
            'celular',
            'descripcion',
            'archivo',
            'avance_1',
            'avance_2',
            'avance_3',
            'avance_4',
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
