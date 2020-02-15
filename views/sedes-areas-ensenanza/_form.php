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
/* @var $model app\models\SedesAreasEnsenanza */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-areas-ensenanza-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sedes')->dropDownList( $sedes ) ?>

    <?= $form->field($model, 'id_areas_ensenanza')->dropDownList( $areas, [ 'prompt' => 'Selecione...' ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
