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
Fecha: 09-04-2018
Persona encargada: Edwin Molina Grisales
CRUD de RECURSOS DE INFRAESTRUCTURA PEDAGOGICA
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecursoInfraestructuraPedagogica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recurso-infraestructura-pedagogica-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_sede')->dropDownList( $sedes ) ?>
    
	<?= $form->field($model, 'cantidad_computdores_portatiles')->textInput() ?>

    <?= $form->field($model, 'cantidad_aulas_tita')->textInput() ?>

    <?= $form->field($model, 'cantidad_bibliotecas')->textInput() ?>

    <?= $form->field($model, 'cantidad_ludotecas')->textInput() ?>

    <?= $form->field($model, 'cantidad_salones_juegos')->textInput() ?>
	
    <?= $form->field($model, 'observaciones')->textarea(['rows' => '6']) ?>

    <?= $form->field($model, 'estado')->dropDownList( $estados ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
