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
/* @var $model app\models\ParticipacionProyectosJornadaBuscar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participacion-proyectos-jornada-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre_programa') ?>

    <?= $form->field($model, 'nombre_participante') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'objetivo') ?>

    <?php // echo $form->field($model, 'duracion') ?>

    <?php // echo $form->field($model, 'ano_inicio') ?>

    <?php // echo $form->field($model, 'ano_fin') ?>

    <?php // echo $form->field($model, 'tematica') ?>

    <?php // echo $form->field($model, 'areas') ?>

    <?php // echo $form->field($model, 'otros') ?>

    <?php // echo $form->field($model, 'materiales_recursos') ?>

    <?php // echo $form->field($model, 'logros') ?>

    <?php // echo $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'id_institucion') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
