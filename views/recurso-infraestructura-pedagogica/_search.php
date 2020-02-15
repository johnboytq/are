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
/* @var $model app\models\RecursoInfraestructuraPedagogicaBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recurso-infraestructura-pedagogica-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cantidad_computdores_portatiles') ?>

    <?= $form->field($model, 'cantidad_aulas_tita') ?>

    <?= $form->field($model, 'cantidad_bibliotecas') ?>

    <?= $form->field($model, 'cantidad_ludotecas') ?>

    <?php // echo $form->field($model, 'cantidad_salones_juegos') ?>

    <?php // echo $form->field($model, 'id_sede') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
