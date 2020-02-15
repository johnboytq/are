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
Fecha: 06-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de sedes-jornadas
---------------------------------------
Modificaciones:
Fecha: 06-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: - Se deja por defecto al select de sedes el valor seleccionado de la vista update o create según se halla llamado
					- Al breadcrumbs le agrego también el id de la sede y la institución
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SedesJornadas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-jornadas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sedes')->dropDownList( $sedes, [ 'value' => $idSedes ]) ?>

    <?= $form->field($model, 'id_jornadas')->dropDownList( $jornadas, ['prompt' => 'Seleccione...' ] ) ?>
	
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
