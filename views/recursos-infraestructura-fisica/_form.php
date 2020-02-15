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
Fecha: 10-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD Recursos Infraestructuras Fisicas
---------------------------------------
Modificaciones:
Fecha: 10-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Se muestra el nombre de los estados
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Estados;
use	yii\helpers\ArrayHelper;

$estado = new Estados;
$estado = $estado->find()->all();
$estado = ArrayHelper::map($estado,'id','descripcion');


/* @var $this yii\web\View */
/* @var $model app\models\RecursosInfraestructuraFisica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recursos-infraestructura-fisica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cantidad_aulas_regulares')->textInput() ?>

    <?= $form->field($model, 'cantidad_aulas_multiples')->textInput() ?>

    <?= $form->field($model, 'cantidad_oficinas_admin')->textInput() ?>

    <?= $form->field($model, 'cantidad_aulas_profesores')->textInput() ?>

    <?= $form->field($model, 'cantidad_espacios_deportivos')->textInput() ?>

    <?= $form->field($model, 'cantidad_baterias_sanitarias')->textInput() ?>

    <?= $form->field($model, 'cantidad_laboratorios')->textInput() ?>

    <?= $form->field($model, 'cantidad_portatiles')->textInput() ?>

    <?= $form->field($model, 'cantidad_computadores')->textInput() ?>

    <?= $form->field($model, 'cantidad_tabletas')->textInput() ?>

    <?= $form->field($model, 'cantidad_bibliotecas_salas_lectura')->textInput() ?>

    <?= $form->field($model, 'programas_informaticos_admin')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'observaciones')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'id_sede')->hiddenInput(['value'=>$idSedes])->label(false); ?>

    <?= $form->field($model, 'estado')->dropDownList($estado,['options' => [1 => ['selected' => 'selected']]]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
