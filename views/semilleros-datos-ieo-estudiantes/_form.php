<?php
/**********
Versión: 001
Fecha: 2018-08-16
Desarrollador: Edwin Molina Grisales
Descripción: Formulario CONFORMACION SEMILLEROS TIC ESTUDIANTES
---------------------------------------
**********/

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SemillerosDatosIeoEstudiantes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semilleros-datos-ieo-estudiantes-form">

	<h3 style='background-color: #ccc;padding:5px;'>DATOS IEO</h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_institucion')->dropDownList([ $institucion->codigo_dane => $institucion->codigo_dane ])->label( 'CÓDIGO DANE IEO' ) ?>
    
	<?= $form->field($model, 'id_institucion')->dropDownList([ $institucion->id => $institucion->descripcion ]) ?>

    <?= $form->field($model, 'id_sede')->textInput(['maxlength' => true])->label( 'CÓDIGO DANE SEDE' ) ?>
	
    <?= $form->field($model, 'id_sede')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profecional_a')->dropDownList( $docentes, [ 'prompt' => 'Seleccione...' ]) ?>

    <?= $form->field($model, 'docente_aliado')->textInput(['maxlength' => true]) ?>

    <!-- <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div> -->
	
	<h3 style='background-color: #ccc;padding:5px;'>ACUERDOS INSTITUCIONES (CONFORMACIÓN)</h3>
	<?= $controller->actionViewFases(); ?>

    <?php ActiveForm::end(); ?>

</div>
