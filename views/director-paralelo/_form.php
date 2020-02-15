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
Fecha: 13-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Director paralelo (grupo)
---------------------------------------
Modificaciones:
Fecha: 13-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Cambio de en los tipos de datos de los campos en los formuarlios (dropDownList)
nombre en la etiqueta del boton save a guardar
se llenas los combobox
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Estados;
use	yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\DirectorParalelo */
/* @var $form yii\widgets\ActiveForm */

//se envia la variable estados con los valores de la tabla estado, siempre es activo
$estados = new Estados();
$estados = $estados->find()->orderby('id')->all();
$estados = ArrayHelper::map($estados,'id','descripcion');
?>

<div class="director-paralelo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_paralelo')->dropDownList($grupos,['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'id_perfiles_x_personas_docentes')->dropDownList($docentes,['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'estado')->dropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
