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
Fecha: 10-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Asignaturas
---------------------------------------
Modificaciones:
Fecha: 01-05-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo AREAS DE ENSEÑANZA al CRUD
---------------------------------------
Modificaciones:
Fecha: 10-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se cambia a dropDownList "id_sedes" y "estado"
Cambio al boton save -> guardar
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Asignaturas */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="asignaturas-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= $form->field($model, 'id_sedes')->dropDownList($sedes) ?>
	
	<?= $form->field($model, 'id_areas_ensenanza')->dropDownList($areas, ['prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->dropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
