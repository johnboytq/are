<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProyectosPedagogicosTransversales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyectos-pedagogicos-transversales-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id_sede')->dropDownList( [ $sede->id => $sede->descripcion ] ) ?>
	
    <?= $form->field($model, 'codigo_grupo')->textInput() ?>

    <?= $form->field($model, 'nombre_grupo')->textInput() ?>

    <?= $form->field($model, 'coordinador')->dropDownList( $personas, [ 'prompt' => 'Seleccione...' ] ) ?>

    <?= $form->field($model, 'area')->dropDownList( $areas, [ 'prompt' => 'Seleccione...' ]) ?>

    <?= $form->field($model, 'correo')->textInput() ?>

    <?= $form->field($model, 'celular')->textInput() ?>

    <?= $form->field($model, 'linea_investigacion_1')->textInput() ?>

    <?= $form->field($model, 'linea_investigacion_2')->textInput() ?>

    <?= $form->field($model, 'linea_investigacion_3')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
