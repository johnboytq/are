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
Descripción: Formulario de Escolaridades
---------------------------------------
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PersonasEscolaridades */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-escolaridades-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_personas')->dropDownList($personas, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'id_escolaridades')->dropDownList($escolaridades, ['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'ultimo_nivel_cursado')->textInput(['maxlength' => true,'placeholder'=> 'Digite el ultmo nivel cursado', 'id' =>'txtNivel']) ?>

    <?= $form->field($model, 'ano_curso')->textInput(['maxlength' => true,'placeholder'=> 'Digite el año del curso', 'id' =>'txtAnoCurso']) ?>

    <?= $form->field($model, 'titulacion')->checkbox() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true,'placeholder'=> 'Digite el título', 'id' =>'txtTitulo']) ?>

    <?= $form->field($model, 'institucion')->textInput(['maxlength' => true,'placeholder'=> 'Digite la institución', 'id' =>'txtInst']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
