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
Fecha: Fecha en formato (09-03-2018)
Desarrollador: Viviana Rodas
Descripción: Formulario de formaciones
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonasFormaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-formaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_personas')->dropDownList($personas, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'id_tipos_formaciones')->dropDownList($formaciones, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'horas_curso')->textInput(['maxlength' => true,'placeholder'=> 'Digite las horas del curso', 'id' =>'txtHoras']) ?>

    <?= $form->field($model, 'ano_curso')->textInput(['maxlength' => true,'placeholder'=> 'Digite el año', 'id' =>'txtAno']) ?>

    <?= $form->field($model, 'titulacion')->checkbox() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true,'placeholder'=> 'Digite el título', 'id' =>'txtTitulo']) ?>

    <?= $form->field($model, 'institucion')->textInput(['maxlength' => true,'placeholder'=> 'Digite la institución', 'id' =>'txtInst']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
