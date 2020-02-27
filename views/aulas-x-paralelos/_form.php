<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AulasXParalelos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aulas-xparalelos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($paralelosSearch, 'ano_lectivo' )->textInput( [ 'prompt' => 'Seleccione...', 'onchange'=>'w0.submit();' ] ) ?>
	
    <?= $form->field($paralelosSearch, 'id_sedes_jornadas' )->dropDownList( $jornadas, [ 'prompt' => 'Seleccione...', 'onchange'=>'w0.submit();'  ] )->label('Jornada') ?>
	
    <?= $form->field($nivelesSearch, 'id' )->dropDownList( $niveles, [ 'prompt' => 'Seleccione...' ] )->label('Nivel') ?>
	
    <?= $form->field($model, 'id_paralelos')->dropDownList( $grupos, [ 'prompt' => 'Seleccione...' ] ) ?>
	
    <?= $form->field($model, 'id_aulas')->dropDownList( $aulas, [ 'prompt' => 'Seleccione...' ] ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success' ,'name' => 'is_save' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
