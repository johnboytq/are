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
Fecha: 17-03-2018
Desarrollador: Oscar David Lopez
Descripción: CRUD de ponderacion-resultados
---------------------------------------
Modificaciones:
Fecha: 17-03-2018
Persona encargada: Oscar David Lopez
Cambios realizados: - nombre de los botones 
cambio de los campos id_periodo y estado a dropDownList
---------------------------------------
**********/
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PonderacionResultados */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile(Yii::$app->request->baseUrl.'/js/ponderacionResultados.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script>
idSede = <?php echo $idSedes; ?>;

</script>


<div class="ponderacion-resultados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_periodo')->dropDownList($periodos,['prompt'=>'Seleccione...']) ?>

    <?= $form->field($model, 'calificacion')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList($estados) ?>
	
    <?= $form->field($model, 'id_sede')->hiddenInput(['value'=>$idSedes])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
