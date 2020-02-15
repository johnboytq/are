<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SemillerosTicDiarioDeCampo */

$this->title = "Detalles";
$this->params['breadcrumbs'][] = ['label' => 'Semilleros Tic Diario De Campos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semilleros-tic-diario-de-campo-view">

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
            'id',
            'id_ejecucion_fase',
            'descripcion',
            'hallazgos',
            'estado',
        ],
    ]) ?>

</div>
