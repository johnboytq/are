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
Fecha: 16-04-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Apoyo Academico
---------------------------------------
Modificaciones:
Fecha: 12-06-2018
Persona encargada: Edwin Molina Grisales
Cambios realizados: Se agrega campo REMITIDO A EPS y se agregan el select chosen para doctores y estudiantes
---------------------------------------
Modificaciones:
Fecha: 16-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se renombran los labels del boton
se organizan alguno campos para que muestren los valores respentivo en lugar de los id
---------------------------------------
Modificaciones:
Fecha: 16-04-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se importa el js y se habilita el campo de incapacidad con su check box
---------------------------------------
**********/

$this->registerJsFile(Yii::$app->request->baseUrl.'/js/apoyoAcademico.js',['depends' => [\yii\web\JqueryAsset::className()]]);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ApoyoAcademico */
/* @var $form yii\widgets\ActiveForm */
use dosamigos\datepicker\DatePicker;
use app\models\Estados;
use app\models\TiposApoyoAcademico;
use	yii\helpers\ArrayHelper;

use nex\chosen\Chosen;


//se envia la variable estados con los valores de la tabla estado, siempre es activo
$estados = new Estados();
$estados = $estados->find()->where('id=1')->all();
$estados = ArrayHelper::map($estados,'id','descripcion');

$apoyoAcademico = new TiposApoyoAcademico();
$apoyoAcademico = $apoyoAcademico->find()->all();
$apoyoAcademico = ArrayHelper::map($apoyoAcademico,'id','descripcion');
$fecha= date("Y-m-d");
?>

<div class="apoyo-academico-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id_tipo_apoyo')->DropDownList($AAcademico,['prompt'=>'Seleccione']) ?>
	
    <?= $form->field($model, 'persona_doctor')->textInput() ?>
	
    <?= $form->field($model, 'registro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_persona_estudiante')->DropDownList($estudiantes) ?>
	
    <?= $form->field($model, 'motivo_consulta')->textarea(['rows' => '6']) ?>
	
	<?= $form->field($model, 'fecha_entrada')->textInput(['readOnly' => true,'value'=>$fecha]);?> 
	
	<?php 
	date_default_timezone_set('America/Bogota');
			$hora = date('H:i:s');
			$horaEntrada = date('h:i A', strtotime($hora));
	echo $form->field($model, 'hora_entrada')->widget(TimePicker::classname(), [
		'options' => 
		[
			'readOnly' => true,
			'showMeridian'=>false,
			'value'=>$horaEntrada,
			
		]]);?>
	
	<?= $form->field($model, 'fecha_salida')->textInput(['readOnly' => true,'value'=>$fecha]);?>
  
    <?= $form->field($model, 'incapacidad')->checkbox() ?>

    <?= $form->field($model, 'no_dias_incapaciad')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'discapacidad')->checkbox() ?>
	
    <?= $form->field($model, 'remitido_eps')->checkbox() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'id_sede')->hiddenInput(['value' => $idSedes])->label(false) ?>

    <?= $form->field($model, 'estado')->DropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
