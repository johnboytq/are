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
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SancionesEstudiantes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sanciones-estudiantes-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id_perfiles_persona')->DropDownList($estudiantes,['prompt'=>'Seleccione...']) ?>
	
    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'fecha')->widget(
    DatePicker::className(), [
        
         // modify template for custom rendering
        'template' => '{addon}{input}',
		    'language' => 'es',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd'
        ]
]);  ?>

    <?= $form->field($model, 'estado')->DropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
