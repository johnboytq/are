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
Fecha: 13-06-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de participantes-grupos-soporte
---------------------------------------
Modificaciones:
Fecha: 13-06-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - se ocula
---------------------------------------
**********/

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipantesGruposSoporte */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="participantes-grupos-soporte-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_grupo_soporte')->hiddenInput(['value'=>$idGruposSoporte])->label(false) ?>

    <?= $form->field($model, 'id_sede')->hiddenInput(['value'=>$_SESSION['sede'][0]])->label(false)?>

    <?= $form->field($model, 'nombre_equipo')->textInput(['readOnly'=>true,'value' => $grupoSoporte,]) ?>

    <?= $form->field($model, 'id_persona')->DropDownList($estudiantes,['prompt'=>'Seleccione...']) ?>
	
	<?= $form->field($model, 'estado')->DropDownList($estados) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success','value'=>"idJornadas='.$idJornadas.'&TiposGruposSoporte='.$TiposGruposSoporte.'&idGruposSoporte='.$idGruposSoporte'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
