<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\GestionCurricularCiclos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gestion-curricular-ciclos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'fecha_inicial')->widget(
				DatePicker::className(), [
					
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => [
					'autoclose' 	=> true,
					'format' 		=> 'yyyy-mm-dd'
				],
			]);  
		?>

   <?= $form->field($model, 'fecha_final')->widget(
				DatePicker::className(), [
					
				 // modify template for custom rendering
				'template' 		=> '{addon}{input}',
				'language' 		=> 'es',
				'clientOptions' => [
					'autoclose' 	=> true,
					'format' 		=> 'yyyy-mm-dd'
				],
			]);  
		?>

    <?= $form->field($model, 'estado')->DropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
