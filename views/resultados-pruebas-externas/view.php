<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Instituciones;

/* @var $this yii\web\View */
/* @var $model app\models\ResultadosPruebasExternas */

$this->title = 'Detalles';
$this->params['breadcrumbs'][] = ['label' => 'Resultados Pruebas Externas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resultados-pruebas-externas-view">

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
            'descripcion',
            'valor',
            [
			'attribute'=>'id_institucion',
			'value' => function( $model )
				{
					$nombreInstituciones = Instituciones::findOne($model->id_institucion);
					return $nombreInstituciones ? $nombreInstituciones->descripcion : '';  
				}, //para buscar por el nombre
			],	
        ],
    ]) ?>

</div>
