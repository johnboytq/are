<?php
if(@$_SESSION['sesion']=="si")
{ 
	// echo $_SESSION['nombre'];
} 
//si no tiene sesion se redirecciona al login
else
{
	echo "<script> window.location=\"index.php?r=site%2Flogin\";</script>";
	die;
}

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inasistencias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inasistencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inasistencias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id_perfiles_x_personas_estudiantes',
            'justificada:boolean',
            'id_distribuciones_academicas',
            'fecha',
            'justificacion',
            'estado',
            'fecha_ing',
        ],
    ]) ?>

</div>
