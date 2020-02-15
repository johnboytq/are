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
/* @var $model app\models\SedesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'telefonos') ?>

    <?= $form->field($model, 'direccion') ?>

    <?= $form->field($model, 'area') ?>

    <?php // echo $form->field($model, 'id_instituciones') ?>

    <?php // echo $form->field($model, 'latitud') ?>

    <?php // echo $form->field($model, 'longitud') ?>

    <?php // echo $form->field($model, 'id_zonificaciones') ?>

    <?php // echo $form->field($model, 'id_tenencias') ?>

    <?php // echo $form->field($model, 'id_modalidades') ?>

    <?php // echo $form->field($model, 'id_municipios') ?>

    <?php // echo $form->field($model, 'id_generos_sedes') ?>

    <?php // echo $form->field($model, 'id_calendarios') ?>

    <?php // echo $form->field($model, 'id_estratos') ?>

    <?php // echo $form->field($model, 'id_barrios_veredas') ?>

    <?php // echo $form->field($model, 'codigo_dane') ?>

    <?php // echo $form->field($model, 'sede_principal') ?>

    <?php // echo $form->field($model, 'comuna') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
