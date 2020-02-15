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
/* @var $model app\models\InfraestructuraEducativa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="infraestructura-educativa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sede')->DropDownList($sedes) ?>

    <?= $form->field($model, 'objeto_intervencion')->checkbox() ?>

    <?= $form->field($model, 'intervencion_infraestructura')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alcance_intervencion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'presupuesto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cumplimiento_pedido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->DropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guarda', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
