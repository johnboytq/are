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
/* @var $model app\models\RecursosInfraestructuraFisicaBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recursos-infraestructura-fisica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cantidad_aulas_regulares') ?>

    <?= $form->field($model, 'cantidad_aulas_multiples') ?>

    <?= $form->field($model, 'cantidad_oficinas_admin') ?>

    <?= $form->field($model, 'cantidad_aulas_profesores') ?>

    <?php // echo $form->field($model, 'cantidad_espacios_deportivos') ?>

    <?php // echo $form->field($model, 'cantidad_baterias_sanitarias') ?>

    <?php // echo $form->field($model, 'cantidad_laboratorios') ?>

    <?php // echo $form->field($model, 'cantidad_portatiles') ?>

    <?php // echo $form->field($model, 'cantidad_computadores') ?>

    <?php // echo $form->field($model, 'cantidad_tabletas') ?>

    <?php // echo $form->field($model, 'cantidad_bibliotecas_salas_lectura') ?>

    <?php // echo $form->field($model, 'programas_informaticos_admin') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
