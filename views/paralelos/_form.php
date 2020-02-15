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
use yii\helpers\ArrayHelper;

use app\models\Jornadas;
use app\models\Niveles;
use app\models\Sedes;
use app\models\SedesJornadas;


/* @var $this yii\web\View */
/* @var $model app\models\Paralelos */
/* @var $form yii\widgets\ActiveForm */


/**********
Versión: 001
Fecha: 09-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Paralelos
---------------------------------------
Modificaciones:
Fecha: 09-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio a dropDownList en id_sedes_jornadas y en id_sedes_niveles los cuales 
reciben como parametro las jornadas y los niveles que estan disponibles para la sede seleccionada.
---------------------------------------
**********/
?>

<div class="paralelos-form">

<?php $fecha = date ( 'Y-m-d H:m:s' ); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'placeholder'=> 'Digite la descripcion']) ?>
	
    <?= $form->field($model, 'id_sedes_jornadas')->dropDownList($jornadas, [ 'prompt' => 'Seleccione...']) ?>

    <?= $form->field($model, 'id_sedes_niveles')->dropDownList($niveles, [ 'prompt' => 'Seleccione...']) ?>

    <?= $form->field($model, 'ano_lectivo')->textInput(['placeholder'=> 'Digite el(los) año(s) lectivo(s)']) ?>

    <?= $form->field($model, 'fecha_ingreso')->hiddenInput(['value'=> $fecha])->label(false)?>

    <?= $form->field($model, 'estado')->dropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
