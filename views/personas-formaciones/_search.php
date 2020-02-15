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

/* @var $this yii\web\View */
/* @var $model app\models\PersonasFormacionesBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personas-formaciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_personas') ?>

    <?= $form->field($model, 'id_tipos_formaciones') ?>

    <?= $form->field($model, 'horas_curso') ?>

    <?= $form->field($model, 'ano_curso') ?>

    <?= $form->field($model, 'titulacion')->checkbox() ?>

    <?php // echo $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'institucion') ?>

    <?php // echo $form->field($model, 'id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
