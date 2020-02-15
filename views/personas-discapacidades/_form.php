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

/**********
Versión: 001
Fecha: Fecha en formato (12-03-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario de discapacidades
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonasDiscapacidades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-discapacidades-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_personas')->dropDownList($personas, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'id_tipos_discapacidades')->dropDownList($discapacidades, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
	
    <?= $form->field($model, 'alergico')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
