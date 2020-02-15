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
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InfraestructuraEducativaBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="infraestructura-educativa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_sede') ?>

    <?= $form->field($model, 'objeto_intervencion')->checkbox() ?>

    <?= $form->field($model, 'intervencion_infraestructura') ?>

    <?= $form->field($model, 'alcance_intervencion') ?>

    <?php // echo $form->field($model, 'presupuesto') ?>

    <?php // echo $form->field($model, 'cumplimiento_pedido') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
