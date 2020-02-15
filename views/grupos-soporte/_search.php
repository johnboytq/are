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
/* @var $model app\models\GruposSoporteBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-soporte-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_tipo_grupos') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'id_sede') ?>

    <?= $form->field($model, 'id_jornada_sede') ?>

    <?php // echo $form->field($model, 'edad_minima') ?>

    <?php // echo $form->field($model, 'edad_maxima') ?>

    <?php // echo $form->field($model, 'cantidad_participantes') ?>

    <?php // echo $form->field($model, 'id_docentes') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
