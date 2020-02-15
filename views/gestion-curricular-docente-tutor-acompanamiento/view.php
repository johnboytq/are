<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularDocenteTutorAcompanamiento */

$this->title = "Detalles";
$this->params['breadcrumbs'][] = ['label' => 'Gestion Curricular Docente Tutor Acompanamientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gestion-curricular-docente-tutor-acompanamiento-view">

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
            'fecha',
            'nombre_profesional_acompanamiento',
            'id_docente',
            'id_institucion',
            'id_sede',
        ],
    ]) ?>

</div>
