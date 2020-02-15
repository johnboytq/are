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
Fecha: 12-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 12-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se oculta un campo y se le asigna el valor de la sedes
se cambia el campo id_bloques a dropDownList 
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SedesBloques */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-bloques-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sedes')->hiddenInput(['value'=>$idSedes])->label(false) ?>

    <?= $form->field($model, 'id_bloques')->dropDownList($bloques) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
