<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EjecucionFase */

$this->title = "Detalles";
$this->params['breadcrumbs'][] = ['label' => 'Ejecucion Fases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ejecucion-fase-view">

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
            'id_fase',
            'id_datos_sesiones',
            'docente',
            'asignaturas',
            'especiaidad',
            'paricipacion_sesiones',
            'numero_apps',
            'seiones_empleadas',
            'acciones_realiadas',
            'temas_problama',
            'tipo_conpetencias',
            'observaciones',
            'id_datos_ieo_profesional',
            'estado',
            'numero_sesiones_docente',
        ],
    ]) ?>

</div>
