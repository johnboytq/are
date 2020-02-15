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
Fecha: 03-03-2018
Desarrollador: Edwin Molina Grisales
Descripción: CRUD de aulas
---------------------------------------
Modificaciones:
Fecha: 03-03-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se cambia boton Save por Guardar
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Aulas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aulas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capacidad')->textInput() ?>

    <?= $form->field($model, 'id_sedes')->dropDownList( $sedes ) ?>

    <?= $form->field($model, 'id_tipos_aulas')->dropDownList( $tiposAulas, [ 'prompt' => 'Seleccione...' ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
