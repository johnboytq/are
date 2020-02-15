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
/* @var $model app\models\InstitucionesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instituciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'id_tipos_instituciones') ?>

    <?= $form->field($model, 'id_sectores') ?>

    <?= $form->field($model, 'nit') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'caracter') ?>

    <?php // echo $form->field($model, 'especialidad') ?>

    <?php // echo $form->field($model, 'rector') ?>

    <?php // echo $form->field($model, 'contacto_rector') ?>

    <?php // echo $form->field($model, 'correo_electronico_institucional') ?>

    <?php // echo $form->field($model, 'pagina_web') ?>

    <?php // echo $form->field($model, 'codigo_dane') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
