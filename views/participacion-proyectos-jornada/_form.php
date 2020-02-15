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
Fecha: 24-05-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de participacion proyectos jornada
---------------------------------------
Modificaciones:
Fecha: 24-05-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - Nombre botones
campos con los tipos de datos correspondientes
campos fecha con datepicker
se llena el campo nombre participante dependiendo del tipo que seleccionen
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/participacion-proyectos-jornada.js',['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model app\models\ParticipacionProyectosJornada */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participacion-proyectos-jornada-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_programa')->DropDownList($nombrePrograma,["prompt"=>"Seleccione..."]) ?>

    <?= $form->field($model, 'tipo')->DropDownList($tipo,["prompt"=>"Seleccione..."]) ?>
	
	<?= $form->field($model, 'nombre_participante')->DropDownList([]) ?>

    <?= $form->field($model, 'objetivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'duracion')->textInput(['maxlength' => true]) ?>

	
	<?= $form->field($model, 'ano_inicio')->widget(
		DatePicker::className(), [
			
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => 
				[
					'autoclose' 	=> true,
					'format' 		=> 'yyyy-mm-dd',
					'readonly' => true,
				]
				
	]);?> 
	
	<?= $form->field($model, 'ano_fin')->widget(
		DatePicker::className(), [
			
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => 
				[
					'autoclose' 	=> true,
					'format' 		=> 'yyyy-mm-dd',
				]
	]);?> 


    <?= $form->field($model, 'tematica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'areas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'materiales_recursos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logros')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observaciones')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_institucion')->hiddenInput(['value'=> $idInstitucion])->label(false)?>

    <?= $form->field($model, 'estado')->DropDownList($estado) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

