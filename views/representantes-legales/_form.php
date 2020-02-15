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
Fecha: 27-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de Representantes Legales (Estudiantes)
---------------------------------------
Modificaciones:
Fecha: 27-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se cambian los campos a dropDownList
cambio en el modelo para guardar en la tabla representante_legales
Nombre de los botones
---------------------------------------
Modificaciones:
Fecha: 28-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se le agrega la opcion selected a los campos 
**********/


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RepresentantesLegales */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="representantes-legales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_perfiles_x_personas')->dropDownList($estudiantes,['prompt' => 'Seleccione...'])->label("Estudiante") ?>
    
	
	<?= $form->field( $model, 'id_personas' )->dropDownList( $representantesLegales , [ 'prompt' => 'Seleccione...'] ) ?>
																					
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
