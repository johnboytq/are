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
Fecha: Fecha en formato (22-03-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario distribuciones academicas - indicador de desempeño
---------------------------------------
******/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DistribucionesIndicadorDesempeno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribuciones-indicador-desempeno-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_distribuciones')->dropDownList($distribuciones, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'id_indicador_desempeno')->dropDownList($indicadores, ['prompt'=>'Seleccione...']) ?>

     <?= $form->field($model, 'estado')->dropDownList($estados, ['prompt'=>'Seleccione...']) ?>
	
	<div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
