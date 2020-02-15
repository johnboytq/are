<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Convocatorias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="convocatorias-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id_sede')->dropDownList([ $sede->id => $sede->descripcion ]) ?>
	
    <?= $form->field($model, 'nro_convocatoria')->textInput() ?>

    <?= $form->field($model, 'grupo')->textInput() ?>

	<?= $form->field($model, 'fecha_inicio')->widget(
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
    
	<?= $form->field($model, 'estado' )->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
