<?php

/**********
Versión: 001
Fecha: 2018-08-21
Desarrollador: Edwin Molina Grisales
Descripción: Formulario EJECUCION FASE III
---------------------------------------
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EjecucionFase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ejecucion-fase-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= $this->render( 'sesiones', [ 
										'idPE' 			=> null,
										'model' 		=> $model,
										'institucion' 	=> $institucion,
										'sede' 			=> $sede,
										'docentes' 		=> $docentes,
										'fase' 		=> $fase,
									]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
