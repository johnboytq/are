<?php

/**********
Versión: 001
Fecha: 2018-08-21
Desarrollador: Edwin Molina Grisales
Descripción: Formulario EJECUCION FASE I
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EjecucionFase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejecucion-fase-form">

	<h3 style='background-color:#ccc;padding:5px;'><?= Html::encode( 'DATOS IEO' ) ?></h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_fase')->dropDownList([ $institucion->id => $institucion->descripcion ])->label( 'Institución educativa' )?>

    <?= $form->field($model, 'id_datos_sesiones')->dropDownList([ $sede->id => $sede->descripcion ])->label( 'Sede' ) ?>

    <?= $form->field($model, 'docente')->dropDownList( $docentes, [ 'prompt' => 'Seleccione...' ] )->label('Profesional A.') ?>
    
	<?= $this->render( 'sesiones', [ 
										'idPE' => null,
										'model' => $model,
									]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
