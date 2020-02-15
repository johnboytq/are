<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularBitacorasVisitasIeo */

$this->title = "Detalles";
$this->params['breadcrumbs'][] = ['label' => 'Gestion Curricular Bitacoras Visitas Ieos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gestion-curricular-bitacoras-visitas-ieo-view">

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
            // 'id',
            'fecha_inicio',
            'fecha_fin',
            'id_persona_docente_tutor',
            'id_institucion',
            'id_sede',
            'id_jornada',
            // 'estado',
        ],
    ]) ?>

</div>
